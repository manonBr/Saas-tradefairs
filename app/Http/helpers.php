<?php

if(!function_exists('databaseToArray')) {
    
    /**
    * Turn the result of a database query into a multidimensionnal Array
    *
    * @param Object Object directly from database query
    * @param Array $keys Must be an array even with one key needed ['title', 'date']. No ID needed
    * @return Array
    */
    function databaseToArray($datas, $keys) {
        $results=[];
        foreach($datas as $data) {
            $results[$data->id]['id'] = $data->id;
            foreach($keys as $index => $key) {
                $results[$data->id][$key] = $data->$key;
            }
        }
        return $results;
    }

}

if(!function_exists('prevent_injection')) {
   
    /**
    * Clean entries to prevent injections
    *
    * @param Array $datas from a form
    * @return Array
    */
    function prevent_injection(array $datas): array {
        foreach($datas as $key => $data) {
            $datasClean[$key] = strip_tags($data);  /** filter_var() instead of strip_tags **/
        }

        return $datasClean;
    }
}

if(!function_exists('alreadyExistInDatabase')) {

    function alreadyExistInDatabase(string $modelName, string|int $data, string $columnToCheck):bool {
        $data = str_replace(' ', '', strtolower($data));
        $model = 'App\Models\\' . $modelName;
        
        return $model::where($columnToCheck, $data)->exists();
    }
}

