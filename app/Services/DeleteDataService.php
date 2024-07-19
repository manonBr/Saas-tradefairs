<?php

namespace App\Services;

class DeleteDataService {

    /**
     * Delete a data from DB
     *
     * @param $service
     * @param integer $id
     * @return void
     */
    public function execute($service, int $id) {    
        $data = $service->find($id);
        try {
            $data->delete();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }        
    }


}