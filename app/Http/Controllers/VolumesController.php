<?php

namespace App\Http\Controllers;

use App\Services\VolumeService;

use App\Services\DeleteDataService;

use Illuminate\Http\Request;
use App\Http\Requests\VolumeRequest;
use App\Http\Requests\VolumeUpdateRequest;

class VolumesController extends Controller
{

    public function __construct(
        private VolumeService $volumes,
        private DeleteDataService $deleteData
    ) {
        $this->volumes = $volumes;
        $this->deleteData = $deleteData;
    }

    public function add(VolumeRequest $request) {
        $datas = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        try {
            $this->volumes->store($datas);  
            return redirect()->route('settings')->with(['success' => 'Nouveau volume enregistré']);
        } catch (\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
    }

    public function update(VolumeUpdateRequest $request) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

        try {
            $this->volumes->update($datas);
            return redirect()->route('settings')->with(['success' => 'Volume mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
    }
    
    public function delete(int $id) {
        try{
            $this->deleteData->execute($this->volumes, $id);
            return redirect()->route('settings')->with(['success' => 'Volume supprimé']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }
        
    }

    public function ajaxrequest(int $id) {
        try {
            return $this->volumes->find($id);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

}
