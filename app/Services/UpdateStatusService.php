<?php

namespace App\Services;

use App\Services\ProductsFormatsService;

class UpdateStatusService {

    /**
     * Enable or disable data
     *
     * @param [type] $service
     * @param integer $id
     * @param integer $currentStatus
     * @param boolean $idInUpdate
     * @return void
     */
    public function execute($service, int $id, int $currentStatus, $idInUpdate = false) {
        $datas = array(
            'id' => $id,
            'active' => !boolval($currentStatus)
        );

        if($idInUpdate) {
            $service->update($datas, $id);
        } else {
            $service->update($datas);
        }
    }

}