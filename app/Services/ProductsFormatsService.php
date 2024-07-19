<?php

namespace App\Services;

use App\Models\Nicotine;
use App\Models\Volume;
use App\Models\ProductType;
use App\Models\ProductTypeVolumesNicotines;

use App\Services\NicotineService;
use App\Services\ProductTypeService;
use App\Services\VolumeService;

use App\Services\CreateArrayForSelectService;
use App\Services\SetContextualDatasForDashboarRenderService;

use Illuminate\Database\Eloquent\Collection;
 
class ProductsFormatsService {

    public function __construct(
        private NicotineService $nicotines,
        private ProductTypeService $productTypes,
        private VolumeService $volumes,
        private CreateArrayForSelectService $createArrayForSelect,
        private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
    ) {
        $this->nicotines = $nicotines;
        $this->productTypes = $productTypes;
        $this->volumes = $volumes;
        $this->createArrayForSelect = $createArrayForSelect;
        $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return ProductTypeVolumesNicotines::find($id);

    }

    public function findAll(string $orderby = 'active', bool $orderAsc = false):Collection {
        $order = ($orderAsc) ? 'asc' : 'desc';

        $formats = ProductTypeVolumesNicotines::select('product_type_volumes_nicotines.id', 'product_type_volumes_nicotines.active AS active','product_type.label AS productType','volumes.label AS volume', 'nicotines.label AS nicotineLevel')
            ->join('product_type', 'product_type_volumes_nicotines.productType_id', '=', 'product_type.id')
            ->join('volumes', 'product_type_volumes_nicotines.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'product_type_volumes_nicotines.nicotines_id', '=', 'nicotines.id')
            ->orderBy($orderby, $order)
            ->orderBy('product_type.order', 'asc')
            ->orderBy('volumes.volume', 'asc')
            ->orderBy('nicotines.value', 'asc')
            ->get();

        return $formats;

    }

    public function findByAttributes(int $productTypeId, int $volumesId, int $nicotinesId) {
        $format = ProductTypeVolumesNicotines::select('product_type_volumes_nicotines.id', 'product_type_volumes_nicotines.active AS active','product_type.label AS productType','volumes.label AS volume', 'nicotines.label AS nicotineLevel')
            ->join('product_type', 'product_type_volumes_nicotines.productType_id', '=', 'product_type.id')
            ->join('volumes', 'product_type_volumes_nicotines.volumes_id', '=', 'volumes.id')
            ->join('nicotines', 'product_type_volumes_nicotines.nicotines_id', '=', 'nicotines.id')
            ->where('product_type_volumes_nicotines.productType_id', '=', $productTypeId)
            ->where('product_type_volumes_nicotines.volumes_id', '=', $volumesId)
            ->where('product_type_volumes_nicotines.nicotines_id', '=', $nicotinesId)
            ->first();

        return $format;
    }

    public function store($datas) {
        unset($datas['_token']);
        $productFormat = new ProductTypeVolumesNicotines($datas);

        
        try {
            $productFormat->save();
            return $productFormat->id;
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(array $updatedProductFormat) {
        $productFormat = $this->find($updatedProductFormat['id']);
        unset($updatedProductFormat['_token']);

        foreach($updatedProductFormat as $key => $data) {
            $productFormat->$key = $data;
        }

        try {
            $productFormat->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getDatasToDisplay(): array {
        $data['datas'] = $this->findAll();
        $data['editable'] = false;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Formats de produit',
            'productsFormats',
            ['active' => 'Actif', 'productType' => 'Catégorie de produit', 'volume' => 'Volume', 'nicotineLevel' => 'Nicotine'],
            array(
                array(
                    'active','input', 'checkbox', [
                        'placeholder' => 'Actif',
                        'value' => true
                    ]
                ),
                array(
                    'productType_id', 'select', [
                        'caption' => 'Veuillez choisir une catégorie',
                        'required' => true,
                        'options' => $this->createArrayForSelect->execute($this->productTypes->findAll())
                    ]
                ),
                array(
                    'volumes_id','select', [
                        'caption' => 'Veuillez choisir un volume',
                        'required' => true,
                        'options' => $this->createArrayForSelect->execute($this->volumes->findAll())
                    ]
                ),
                array(
                    'nicotines_id','select', [
                        'caption' => 'Veuillez choisir un taux de nicotine',
                        'required' => true,
                        'options' => $this->createArrayForSelect->execute($this->nicotines->findAll())
                    ]
                )
            )
        );

        return $data;
    }

}