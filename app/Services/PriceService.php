<?php

namespace App\Services;

use App\Models\Price;

use Illuminate\Database\Eloquent\Collection;
 
class PriceService {

    public function findAll(bool $returnArray = false): Collection|array {

        $data = Price::select('prices.*','product_type_volumes.*','product_type.*', 'volumes.*')
            ->join('product_type_volumes', 'prices.productTypeVolume_id', '=', 'product_type_volumes.id')
            ->join('product_type', 'product_type_volumes.productType_id', '=', 'product_type.id')
            ->join('volumes', 'product_type_volumes.volumes_id', '=', 'volumes.id')
            ->get();

        if($returnArray) {
            foreach($data as $price) {
                $prices[$price->ranges_id]['prices'][$price->type . $price->volume] = $price->amount;
            }
            return $prices;
        }

        return $data;
        
    }

}