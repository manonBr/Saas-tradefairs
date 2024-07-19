<?php

namespace App\Http\Controllers;

use App\Services\ProductsFormatsService;

use App\Services\DeleteDataService;
use App\Services\UpdateStatusService;

use Illuminate\Http\Request;
use App\Http\Requests\ProductFormatRequest;
use App\Http\Requests\ProductFormatUpdateRequest;

class ProductsFormatsController extends Controller
{
    public function __construct(
        private ProductsFormatsService $productsFormats,
        private DeleteDataService $deleteData,
        private UpdateStatusService $updateStatus
    ) {
        $this->productsFormats = $productsFormats;
        $this->deleteData = $deleteData;
        $this->updateStatus = $updateStatus;
    }

    /**
     * Display product form
     *
     * @return view
     */
    public function render(){
        $datas = $this->productsFormats->getDatasToDisplay();

        return view('dashboard.default-table', ['content' => $datas['content'], 'datas' => $datas['datas'], 'editable' => $datas['editable']]);
    }

    public function add(ProductFormatRequest $request) {
        $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            $this->productsFormats->store($datas);
            
            return redirect()->route('productsFormats')->with(['success' => 'Nouveau format de produit enregistré']);
        } catch (\Exception $e) {
            return redirect()->route('productsFormats')->with(['error' => $e->getMessage()]);
        }
    }

    public function update(ProductFormatUpdateRequest $request) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

        try {
            $this->productsFormats->update($datas);
            return redirect()->route('productsFormats')->with(['success' => 'Format de produit mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('productsFormats')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(int $id, int $currentStatus) {
        try {
            $this->updateStatus->execute($this->productsFormats, $id, $currentStatus);
            return redirect()->route('productsFormats')->with(['success' => 'Statut du format de produit mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('productsFormats')->with(['error' => $e->getMessage()]);
        }
    }

    public function delete(int $id) {
        try{
            $this->deleteData->execute($this->productsFormats, $id);
            return redirect()->route('productsFormats')->with(['success' => 'Format de produit supprimé']);
        } catch(\Exception $e) {
            return redirect()->route('productsFormats')->with(['error' => $e->getMessage()]);
        }
        
    }

    public function ajaxrequest(int $id) {
        try {
            return $this->productsFormats->find($id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
