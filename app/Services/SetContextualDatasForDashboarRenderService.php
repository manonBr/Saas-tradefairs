<?php

namespace App\Services;
 
class SetContextualDatasForDashboarRenderService {


    /**
     * Organize datas, so they are ready to be displayed in the [components.dashboard.table-default]
     *
     * @param string $title
     * @param string $pageName
     * @param array $columns
     * @param array $formInputs
     * @return array
     */
    public function execute(
        string $title, 
        string $pageName, 
        array $columns, 
        array $formInputs = null
    ): array {

        $data['title'] = $title;
        $data['page'] = $pageName;
        foreach($columns as $key => $columnLabel) {
            $data['columns'][] = $key;
            $data['table-label'][] = $columnLabel;

        }
        if($formInputs) {
            foreach($formInputs as $input) {
                if($input[1] === 'input') {
                    $data['form'][$input[0]] = array(
                        'name' => $input[0],
                        'format' => $input[1],
                        'type' => $input[2]
                    );
                    foreach($input[3] as $key => $value){
                        $data['form'][$input[0]][$key] = $value;
                    }
                } else {
                    $data['form'][$input[0]] = array(
                        'name' => $input[0],
                        'format' => $input[1],
                        'placeholder' => $input[2],
                    );
                    foreach($input[2] as $key => $value){
                        $data['form'][$input[0]][$key] = $value;
                    }
                }
            }
        }

        return $data;

    }

}