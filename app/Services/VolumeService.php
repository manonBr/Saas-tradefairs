<?php

namespace App\Services;

use App\Models\Volume;

use App\Services\SetContextualDatasForDashboarRenderService;
 
class VolumeService {

    public function __construct(
        private SetContextualDatasForDashboarRenderService $setContextualDatasForDashboarRender
    ) {
        $this->setContextualDatasForDashboarRender = $setContextualDatasForDashboarRender;
    }

    public function find(int $id){

        return Volume::find($id);

    }

    public function findAll() {
        return Volume::orderBy('volume', 'asc')->get();
    }

    public function findByValue(int $volume) {
        $format = Volume::select('*')
            ->where('volumes.volume', '=', $volume)
            ->first();

        return $format;
    }

    public function store(array $datas) {
        if($this->alreadyExist($datas['volume'])) {
            return false;
        }
       
        $volume = new Volume($datas);

        try {
            $volume->save();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    public function update(array $updatedVolume) {
        $volume = $this->find($updatedVolume['id']);
        unset($updatedVolume['_token']);

        foreach($updatedVolume as $key => $data) {
            $volume->$key = $data;
        }

        try {
            $volume->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function alreadyExist(string|int $data):bool {
        $data = str_replace(' ', '', strtolower($data));
        
        return Volume::where('volume', $data)->exists();
    }

    public function getDatasToDisplay(): array {
        $data['datas'] = $this->findAll();
        $data['editable'] = true;
        $data['content'] = $this->setContextualDatasForDashboarRender->execute(
            'Volumes',
            'volumes',
            ['id' => 'ID', 'volume' => 'Volume', 'label' => 'Intitulé'],
            array(
                array(
                    'volume','input', 'number', [
                        'placeholder' => 'Volume (en chiffres)',
                        "step" => '1'
                    ]
                ),
                array(
                    'label','input', 'text', [
                        'placeholder' => 'Volume avec unité de mesure'
                    ]
                )
            )
        );

        return $data;
    }

}