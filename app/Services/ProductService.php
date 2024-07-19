<?php

namespace App\Services;

use App\Models\Product;

use App\Services\CheckIfProductFormatExistService;
use App\Services\ProductsFormatsService;
use App\Services\SetContextualDatasForDashboarRenderService;

use Illuminate\Database\Eloquent\Collection;
 
class ProductService {
        
        public function __construct(
            private CheckIfProductFormatExistService $checkIfProductFormatExist,
            private ProductsFormatsService $productsFormats,
            private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
        ) {
            $this->checkIfProductFormatExist = $checkIfProductFormatExist;
            $this->productsFormats = $productsFormats;
            $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return Product::find($id);

    }

    public function findAll(bool $returnArray = false): Collection|array {
        $datas = Product::select('products.*', 'volumes.volume AS volume', 'nicotines.value AS nicotine')
            ->join('volumes', 'products.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'products.nicotines_id', '=', 'nicotines.id')
            ->orderBy('ranges_id')
            ->orderBy('name_shorten', 'asc')
            ->orderBy('volume', 'asc')
            ->orderBy('nicotine', 'asc')
            ->get();
        
        if($returnArray){
            foreach($datas as $product) {
                $products[$product->ranges_id][$product->id] = $product;
            }

            return $products;
        }

        return $datas;
    }

    public function findAllUnofficial(bool $returnArray = false): Collection|array {
        $datas = Product::select('products.*', 'volumes.volume AS volume', 'nicotines.value AS nicotine')
            ->join('volumes', 'products.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'products.nicotines_id', '=', 'nicotines.id')
            ->orderBy('ranges_id')
            ->orderBy('name_shorten', 'asc')
            ->orderBy('volume', 'asc')
            ->orderBy('nicotine', 'asc')
            ->where('products.code_art', 'LIKE', 'UO-%')
            ->get();
        
        if($returnArray){
            foreach($datas as $product) {
                $products[$product->ranges_id][$product->id] = $product;
            }

            return $products;
        }

        return $datas;
    }

    public function findAllActive(bool $returnArray = false): Collection|array {

        $data = Product::select('products.*','ranges.active','product_type.type','volumes.volume AS volume', 'nicotines.value AS nicotine')
            ->join('ranges', 'products.ranges_id', '=', 'ranges.id')
            ->join('volumes', 'products.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'products.nicotines_id', '=', 'nicotines.id')
            ->join('product_type', 'products.productType_id', '=', 'product_type.id')
            ->join('product_type_volumes_nicotines', 'products.productTypeVolumesNicotines_id', '=', 'product_type_volumes_nicotines.id')
            ->orderBy('ranges.range', 'asc')
            ->orderBy('name_shorten', 'asc')
            ->orderBy('volume', 'asc')
            ->orderBy('nicotine', 'asc')
            ->where([
                'ranges.active' => '1',
                'product_type_volumes_nicotines.active' => 1,
                'products.active' => '1'
            ])
            ->get();
        
        if($returnArray){
            foreach($data as $item) {
                $products[$item->ranges_id][$item->name_shorten][$item->type][$item->volume][$item->nicotine] = $item;
            }

            return $products;
        }
        
        return $data;

    }

    public function findAllActiveUnofficial(bool $returnArray = false): Collection|array {

        $datas = Product::select('products.*','ranges.active','product_type.type','volumes.volume AS volume', 'nicotines.value AS nicotine')
            ->join('ranges', 'products.ranges_id', '=', 'ranges.id')
            ->join('volumes', 'products.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'products.nicotines_id', '=', 'nicotines.id')
            ->join('product_type', 'products.productType_id', '=', 'product_type.id')
            ->join('product_type_volumes_nicotines', 'products.productTypeVolumesNicotines_id', '=', 'product_type_volumes_nicotines.id')
            ->orderBy('ranges.range', 'asc')
            ->orderBy('name_shorten', 'asc')
            ->orderBy('volume', 'asc')
            ->orderBy('nicotine', 'asc')
            ->where([
                'ranges.active' => '1',
                'product_type_volumes_nicotines.active' => 1,
                'products.active' => '1'
            ])
            ->where('products.code_art', 'LIKE', 'UO-%')
            ->get();
        
        if($returnArray){
            foreach($datas as $product) {
                $products[$product->ranges_id][$product->name_shorten . ' - ' . $product->volume. 'mL'][$product->id] = $product;
            }

            return $products;
        }
        
        return $datas;

    }

    public function store(array $datas):bool {

        $product = Product::firstOrNew([
            'code_art' => $datas['code_art']
        ]);
        
        if(!$product->exists){

            $datas['productTypeVolumesNicotines_id'] = $this->checkIfProductFormatExist->execute($datas['productType_id'], $datas['volumes_id'], $datas['nicotines_id']);
            
            $datas['active'] = isset($datas['active']);
            
            $product = new Product($datas);
            if($product->save()){
                return true;
            }
            return false;
        }

        return false;
    }

    public function update(array $updatedProduct, int $productId = 0) {

        if(isset($updatedRange['id'])) {
            $productId = $updatedRange['id'];
        }

        $product = $this->find($productId);
        
        if(
            (isset($updatedProduct['productType_id']) && $updatedProduct['productType_id'] != $product->productType_id) || 
            (isset($updatedProduct['volumes_id']) && $updatedProduct['volumes_id'] != $product->volumes_id) ||
            (isset($updatedProduct['nicotines_id']) && $updatedProduct['nicotines_id'] != $product->nicotines_id)
        ) {
            $updatedProduct['productTypeVolumesNicotines_id'] = $this->checkIfProductFormatExist->execute($updatedProduct['productType_id'], $updatedProduct['volumes_id'], $updatedProduct['nicotines_id']);
        }

        foreach($updatedProduct as $key => $data) {
            $product->$key = $data;
        }

        try {
            $test = $product->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteAll() {
        try {
            Product::truncate();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage);
        }
    }

    public function getDatasToDisplay(): array {
        $data['datas'] = $this->findAllActiveUnofficial();
        $data['editable'] = false;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Produits activés inexistants sur EBP',
            'product',
            ['active' => 'Actif', 'name_shorten' => 'Nom', 'volume' => 'Volume', 'nicotine' => 'Taux de nicotine (mg/mL)']
        );

        return $data;
    }

}