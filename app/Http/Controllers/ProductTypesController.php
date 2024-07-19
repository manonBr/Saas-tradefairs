<?php

namespace App\Http\Controllers;

use App\Services\ProductTypeService;

use App\Services\DeleteDataService;

use Illuminate\Http\Request;
use App\Http\Requests\ProductTypeRequest;
use App\Http\Requests\ProductTypeUpdateRequest;

class ProductTypesController extends Controller
{

    public function __construct(
        private ProductTypeService $productTypes,
        private DeleteDataService $deleteData
    ) {
        $this->productTypes = $productTypes;
        $this->deleteData = $deleteData;
    }

    public function add(ProductTypeRequest $request) {
        $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            $this->productTypes->store($datas);
            
            return redirect()->route('settings')->with(['success' => 'Nouvelle catégorie de produit enregistrée avec succès']);
        } catch (\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
    }

    public function update(ProductTypeUpdateRequest $request) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

        try {
            $this->productTypes->update($datas);
            return redirect()->route('settings')->with(['success' => 'Catégorie de produit mise à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
    }
    
    public function delete(int $id) {
        
        try{
            $this->deleteData->execute($this->productTypes, $id);
            return redirect()->route('settings')->with(['success' => 'Catégorie de produit supprimée avec succès']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
        
    }

    public function ajaxrequest(int $id) {
        try {
            return $this->productTypes->find($id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

}
