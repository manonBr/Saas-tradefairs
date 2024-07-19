<?php

namespace App\Services;

use App\Services\CreateCsvFileService;
 
class ReadCsvFileService {

    /**
     * Extract all datas from a CSV
     *
     * @param string $filename tmp_name
     * @return Array
     */
    public function extractDatasFromCsv(string $filename) {
        $file = fopen($filename, 'r');
        while (!feof($file)) {
            $datas[] = fgetcsv($file, 1500, ',');
        }
        fclose($file);
        ini_set('auto_detect_line_endings', FALSE);

        return $datas;
    }

}