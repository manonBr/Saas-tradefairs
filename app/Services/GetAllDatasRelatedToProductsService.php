<?php

namespace App\Services;

use App\Services\PriceService;
use App\Services\ProductService;
use App\Services\ProductTypeService;

use Illuminate\Database\Eloquent\Collection;
 
class GetAllDatasRelatedToProductsService {

    public function __construct(
        private PriceService $prices,
        private ProductService $products,
        private ProductTypeService $productTypes
    ) {
        $this->products = $products;
        $this->prices = $prices;
        $this->productTypes = $productTypes;
    }

    /**
     * Collect every info available for given products
     *
     * @param Collection $products
     * @return array
     */
    public function execute(Collection $products): array {

        $prices = $this->prices->findAll(true);
               
        foreach($products as $product) {
            if($product->specificPrice > 0 && !isset($datas[$product->ranges_id]['specificPrices'][$product->name_shorten][$product->type][$product->volume])) {
                $specificPrices[$product->ranges_id]['specificPrices'][$product->name_shorten][$product->type][$product->volume] = floatval($product->specificPrice);
            }
        }

        foreach($this->productTypes->findAllActive() as $productType) {          
            $productTypes[$productType->range_id]['productTypes'][$productType->type][$productType->volume][$productType->nicotine] = $productType->nicotine;                   

            if(!isset($nicotines[$productType->range_id]['nicotines'][$productType->type . $productType->volume])) {
                $nicotines[$productType->range_id]['nicotines'][$productType->type . $productType->volume] = [];
            }
            array_push($nicotines[$productType->range_id]['nicotines'][$productType->type . $productType->volume], $productType->nicotine);

            if(!isset($productsItems[$productType->range_id]['products'])) {
                $productsItems[$productType->range_id]['products'] = [];
            }
            array_push($productsItems[$productType->range_id]['products'], [
                'type' => $productType->type,
                'volume' => $productType->volume,
                'nicotine' => $productType->nicotine
            ]);
        }

        return array_replace_recursive($prices, $specificPrices, $productTypes, $nicotines, $productsItems);
        
    }

}