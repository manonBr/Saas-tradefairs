<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductType;

use App\Services\SetContextualDatasForDashboarRenderService;

use Illuminate\Database\Eloquent\Collection;
 
class ProductTypeService {

    public function __construct(
        private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
    ) {
        $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return ProductType::find($id);

    }

    public static function findAll(string $orderby = 'label', bool $orderAsc = true):Collection {
        $order = ($orderAsc) ? 'asc' : 'desc';

        $types = ProductType::orderBy($orderby, $order)->get();

        return $types;

    }

    public function findAllActive(): Collection {

        $data = Product::select('ranges.id AS range_id','ranges.range','products.productType_id','product_type.type AS type','volumes.volume AS volume', 'nicotines.value AS nicotine')
            ->join('ranges', 'products.ranges_id', '=', 'ranges.id')
            ->join('volumes', 'products.volumes_id', '=', 'volumes.id')    
            ->join('nicotines', 'products.nicotines_id', '=', 'nicotines.id')
            ->join('product_type', 'products.productType_id', '=', 'product_type.id')
            ->join('product_type_volumes_nicotines', 'products.productTypeVolumesNicotines_id', '=', 'product_type_volumes_nicotines.id')
            ->orderBy('ranges.range', 'asc')
            ->orderBy('product_type.order', 'asc')
            ->orderBy('volume', 'asc')
            ->orderBy('nicotine', 'asc')
            ->where([
                'ranges.active' => '1',
                'product_type_volumes_nicotines.active' => 1,
                'products.active' => '1'
                ])
                ->groupBy('ranges.id', 'products.productType_id', 'products.volumes_id', 'products.nicotines_id')
            ->get();

        return $data;

    }

    public function store(array $datas) {
        if(alreadyExistInDatabase('ProductType', $datas['type'], 'type')) {
            return false;
        }
       
        $productType = new ProductType($datas);

        try {
            $productType->save();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function update(array $updatedProductType) {
        $productType = $this->find($updatedProductType['id']);
        unset($updatedProductType['_token']);

        foreach($updatedProductType as $key => $data) {
            $productType->$key = $data;
        }

        try {
            $productType->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getDatasToDisplay(): array {
        $data['datas'] = $this->findAll('order');
        $data['editable'] = true;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Catégories de produit',
            'productTypes',
            ['id' => 'ID', 'order' => 'Ordre d\'affichage', 'label' => 'Nom de la catégorie', 'type' => 'Type'],
            array(
                array(
                    'order','input', 'number', [
                        'placeholder' => 'Chiffre entre 0 et 10',
                        "step" => '1'
                    ]
                ),
                array(
                    'label','input', 'text', [
                        'placeholder' => 'Nom de la catégorie'
                    ]
                ),
                array(
                    'type','input', 'text', [
                        'placeholder' => 'Tag de la catégorie'
                    ]
                )
            )
        );

        return $data;
    }

}