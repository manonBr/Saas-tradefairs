<?php

namespace App\Services;

use App\Models\Nicotine;

use App\Services\SetContextualDatasForDashboarRenderService;
 
class NicotineService {

    public function __construct(
        private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
    ) {
        $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return Nicotine::find($id);

    }

    public function findAll() {
        return Nicotine::orderBy('value', 'asc')->get();
    }

    public function findByValue(int $nicotine) {
        $format = Nicotine::select('*')
            ->where('nicotines.value', '=', $nicotine)
            ->first();

        return $format;
    }

    public function store(array $datas) {
        if(alreadyExistInDatabase('Nicotine', $datas['value'], 'value')) {
            return false;
        }
       
        $nicotine = new Nicotine($datas);

        try {
            $nicotine->save();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function update(array $updatedNicotineLevel) {
        $nicotine = $this->find($updatedNicotineLevel['id']);
        unset($updatedNicotineLevel['_token']);

        foreach($updatedNicotineLevel as $key => $data) {
            $nicotine->$key = $data;
        }

        try {
            $nicotine->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getDatasToDisplay() {
        $data['datas'] = $this->findAll();
        $data['editable'] = true;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Taux de nicotine',
            'nicotineLevels',
            ['id' => 'ID', 'value' => 'Taux', 'label' => 'Intitulé'],
            array(
                array(
                    'value','input', 'number', [
                        'placeholder' => 'Taux de nicotine (en chiffres)',
                        "step" => '1'
                    ]
                ),
                array(
                    'label','input', 'text', [
                        'placeholder' => 'Taux de nicotine avec unité de mesure'
                    ]
                )
            )
        );

        return $data;
    }

}