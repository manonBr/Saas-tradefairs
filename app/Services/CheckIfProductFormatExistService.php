<?php

namespace App\Services;

use App\Services\ProductsFormatsService;

class CheckIfProductFormatExistService {

    public function __construct(private ProductsFormatsService $productsFormats) {
        $this->productsFormats = $productsFormats;
    }

    /**
     * Check if a product format exist in database.
     * If not, create a new product format
     *
     * @param int $productTypeId
     * @param int $volumesId
     * @param int $nicotinesId
     * @return integer
     */
    public function execute(int $productTypeId, int $volumesId, int $nicotinesId): int {

        if($productFormat = $this->productsFormats->findByAttributes($productTypeId, $volumesId, $nicotinesId)) {
            return $productFormat['id'];
        } else {
            $newFormatDatas = array(
                'productType_id' => $productTypeId,
                'volumes_id' => $volumesId,
                'nicotines_id' => $nicotinesId,
                'active' => true
            );
            
            return $this->productsFormats->store($newFormatDatas);
        }
    }

}