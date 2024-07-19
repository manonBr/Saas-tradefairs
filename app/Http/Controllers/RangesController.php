<?php

namespace App\Http\Controllers;

use App\Models\Range;

use App\Services\ProductTypeService;
use App\Services\RangeService;

use App\Services\DeleteDataService;
use App\Services\UpdateStatusService;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\RangeRequest;
use App\Http\Requests\RangeUpdateRequest;

class RangesController extends Controller
{

    public function __construct(
        private ProductTypeService $productTypes,
        private RangeService $ranges,
        private DeleteDataService $deleteData,
        private UpdateStatusService $updateStatus
    ) {
        $this->productTypes = $productTypes;
        $this->ranges = $ranges;
        $this->deleteData = $deleteData;
        $this->updateStatus = $updateStatus;
    }

    /**
     * Display all the ranges
     *
     * @return view
     */
    public function render() {
        $datas = $this->ranges->getDatasToDisplay();

        return view('dashboard.default-table', 
            ['content' => $datas['content'], 
            'datas' => $datas['datas'], 
            'editable' => $datas['editable']]);
    }

    public function add(RangeRequest $request) {
        $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            $this->ranges->store($datas);
            
            return redirect()->route('ranges');
        } catch (\Exception $e) {
            return redirect()->route('ranges')->with(['error' => $e->getMessage()]);
        }
        
        
    }

    public function update(RangeUpdateRequest $request) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $datas['active'] = $request->boolean('active');

        try {
            $this->ranges->update($datas);
            return redirect()->route('ranges')->with(['success' => 'Gamme mise à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('ranges')->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(int $id, int $currentStatus) {
        try {
            $this->updateStatus->execute($this->ranges, $id, $currentStatus);
            return redirect()->route('ranges')->with(['success' => 'Statut de gamme mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('ranges')->with(['error' => $e->getMessage()]);
        }
    }
    
    public function delete(int $id) {
        try{
            $this->deleteData->execute($this->ranges, $id);
            return redirect()->route('ranges')->with(['success' => 'Gamme supprimée']);
        } catch(\Exception $e) {
            return redirect()->route('ranges')->with(['error' => $e->getMessage()]);
        }
    }

    public function ajaxrequest(int $id) {
        try {
            return $this->ranges->find($id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
