<?php

namespace App\Services;

use App\Models\Range;

use App\Services\ProductTypeService;

use App\Services\CreateArrayForSelectService;
use App\Services\SetContextualDatasForDashboarRenderService;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
 
class RangeService {

    public function __construct(
        private ProductTypeService $productTypes,
        private CreateArrayForSelectService $createArrayForSelect,
        private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
    ) {
        $this->productTypes = $productTypes;
        $this->createArrayForSelect = $createArrayForSelect;
        $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return Range::find($id);

    }

    public static function findAll(bool $returnArray = false, array $arrayArguments = []): Collection|array {

        $datas = DB::table('ranges')
        ->leftJoin('product_type', 'ranges.type', '=', 'product_type.id')
        ->select('ranges.id', 'ranges.range', 'ranges.code_fam', 'ranges.active', 'product_type.label AS type', 'product_type.type AS type_name')
        ->orderBy('range', 'asc')
        ->get();

        if($returnArray){
            $ranges = databaseToArray($datas,$arrayArguments);

            return $ranges;
        }

        return $datas;

    }

    public function findAllActive(bool $returnArray = false, array $arrayArguments = []): Collection|array {

        $data = Range::select('ranges.id', 'ranges.range', 'ranges.code_fam', 'product_type.label AS type', 'product_type.type AS type_name')
            ->leftJoin('product_type', 'ranges.type', '=', 'product_type.id')
            ->orderBy('range', 'asc')
            ->where('ranges.active', '=', '1')
            ->get();
        
        if($returnArray){
            $ranges = databaseToArray($data,$arrayArguments);

            return $ranges;
        }
        
        return $data;
        
    }

    public function store($datas) {
        $range = new Range($datas);
        
        try {
            $range->save();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(array $updatedRange) {
        $range = $this->find($updatedRange['id']);
        unset($updatedRange['_token']);

        foreach($updatedRange as $key => $data) {
            $range->$key = $data;
        }

        try {
            $range->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function getDatasToDisplay(): array {
        $data['datas'] = $this->findAll();
        $data['editable'] = true;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Gammes',
            'ranges',
            ['active' => 'Actif', 'range' => 'Nom', 'code_fam' => 'Code famille', 'type' => 'Type de produit'],
            array(
                array(
                    'active','input', 'checkbox', [
                        'placeholder' => 'Actif',
                        'value' => true
                    ]
                ),
                array(
                    'range','input', 'text', [
                        'placeholder' => 'Nom de la gamme',
                        'required' => true
                    ]
                ),
                array(
                    'code_fam','input', 'text', [
                        'placeholder' => 'Code famille',
                        'required' => true
                    ]
                ),
                array(
                    'type', 'select', [
                        'caption' => 'Veuillez choisir une catégorie',
                        'required' => true,
                        'options' => $this->createArrayForSelect->execute($this->productTypes->findAll())
                        ]
                )
            )
        );

        return $data;
    }

}