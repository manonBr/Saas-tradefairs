<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
 
class CreateCsvFileService {

    /** 
     * Create a CSV document and store or download it, 
     * depending of the path
     *
     * @param array $datas
     * @param string $filename
     * @param string $path : eg. '../storage/app/public/csv/orders/myfile.csv'
     * @param array $headerTags : eg. ['Name', 'Company]
     * @param string $format : Could be [columns]:default or [inline]
     * @param string $typeOfDelimiter : [;]:default
     * @return void
     */
    public function execute(
        array $datas, 
        string $filename, 
        string $path, 
        array $headerTags, 
        string $format = 'columns', 
        string $typeOfDelimiter = ';'
    ) {

        $this->setHeaderCSV($filename);
        if($output = fopen($path, 'w')) {
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            if($format === 'columns') {
                fputcsv($output, $headerTags, $typeOfDelimiter);
            }
            $this->insertDatasInCSV($datas, $output, $format, $typeOfDelimiter);
            fclose($output);
        } else {
            return redirect()->route('welcome')->witherrors();
        }   
    }

    /**
     * Replace every uncommun csv delimiters by a coma
     *
     * @param string $filename tmp_name
     * @return void
     */
    public function csvReplaceDelimiters(string $filename) {

        // Delimiters to be replaced: pipe, comma, semicolon, caret, tabs
        $delimiters = array('|', ';', '^', "\t");
        $delimiter = ',';
  
        $str = file_get_contents($filename);
        $str = str_replace($delimiters, $delimiter, $str);
        file_put_contents($filename, $str);
    }
   
    /**
     * Set CSV header with below informations
     *
     * @param string $filename
     * @param string $dateFormat
     * @param string $typeOfDelimiter
     * @return void
     */
    public function setHeaderCSV(
        string $filename, 
        string $dateFormat = 'dmYHis', 
        string $typeOfDelimiter = ';' 
    ): void {
        $date = date($dateFormat);
        $delimiter = $typeOfDelimiter;

        ob_start();

        header('Content-Encoding: UTF-8');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename.'-'.$date.'.csv');
        header("Cache-Control: no-store, no-cache");

        ob_end_clean();
    }

    /**
     * Insert datas in CSV in the desire format
     *
     * @param array $datas
     * @param pointer $output : ouput of fopen
     * @param string $format : Could be [columns]:default or [inline]
     * @return void
     */
    public function insertDatasInCSV(
        array $datas, 
        $output, 
        string $format = 'columns', 
        string $typeOfDelimiter = ';'
    ) {
        switch ($format) {
            case 'inline':
                foreach($datas as $key => $data) {
                    if(!fputcsv($output,[$key, $data], $typeOfDelimiter)){
                        return redirect()->route('welcome')->witherrors();
                    }
                }
    
                break;
            case 'columns':
                foreach($datas as $data) {
                    if(!fputcsv($output, $data, $typeOfDelimiter)){
                        return redirect()->route('welcome')->witherrors();
                    }
                }

                break;
            default:
                return redirect()->route('welcome')->witherrors();
          }
    }

}