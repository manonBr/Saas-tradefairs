<?php

namespace App\Http\Controllers;

use App\Services\NicotineService;

use App\Services\DeleteDataService;

use Illuminate\Http\Request;
use App\Http\Requests\NicotineRequest;
use App\Http\Requests\NicotineUpdateRequest;

class NicotineLevelsController extends Controller
{

    public function __construct(
        private NicotineService $nicotines,
        private DeleteDataService $deleteData
    ) {
        $this->nicotines = $nicotines;
        $this->deleteData = $deleteData;
    }
    
    public function add(NicotineRequest $request) {
        $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            $this->nicotines->store($datas);
            return redirect()->route('settings')->with(['success' => 'Nouveau taux de nicotine enregistré']);
        } catch (\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }        
    }

    public function update(NicotineUpdateRequest $request) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

        try {
            $this->nicotines->update($datas);
            return redirect()->route('settings')->with(['success' => 'Taux de nicotine mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
    }
    
    public function delete(int $id) {
        
        try{
            $this->deleteData->execute($this->nicotines, $id);
            return redirect()->route('settings')->with(['success' => 'Taux de nicotine supprimé']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }    
    }

    public function ajaxrequest(int $id) {
        try {
            return $this->nicotines->find($id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

}
