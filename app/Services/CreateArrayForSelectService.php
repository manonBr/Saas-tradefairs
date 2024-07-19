<?php

namespace App\Services;

use App\Services\ProductsFormatsService;

class CreateArrayForSelectService {

    /**
     * Create an array of datas ready to pass to [views.components.form.select]
     *
     * @param Object $datas Collection of datas
     * @param string $label Column name where label is stored in DB ([label] by default)
     * @param string $key Which column should be use as key ([ID] by default)
     * @return Array
     */
    public function execute(Object $datas, string $label = 'label', string $key = 'id'): Array {
        foreach($datas as $data) {
            $response[$data->$key] = $data->$label;
        }

        return $response;
    }

}