<?php

namespace App\Services;

use App\Services\NicotineService;
use App\Services\ProductService;
use App\Services\ProductsFormatsService;
use App\Services\RangeService;
use App\Services\VolumeService;

use App\Services\CheckIfProductFormatExistService;
use App\Services\CreateCsvFileService;
use App\Services\ReadCsvFileService;
 
class ExtractProductsFromFileService {

    CONST DEFAULT_RANGE = 22;
    CONST DEFAULT_VOLUME = 0;

    CONST VOLUME_DATAS = [
        '1' => 10,
        '5' => 50,
        '6' => 60,
        '2' => 1000
    ];

    CONST NO_NICOTINE = [50, 'concentré'];

    const VOLUME_EXCEPTIONS = [
        'FRZ' => [
            'reference' => 15,
            'volume' => 50
        ],
        'YUZ' => [
            'reference' => 1,
            'volume' => 2
        ],
        'YUZME' => [
            'reference' => 1,
            'volume' => 4
        ],
    ];

    public function __construct(
        private NicotineService $nicotines,
        private ProductService $products,
        private ProductsFormatsService $productsFormats,
        private RangeService $ranges,
        private VolumeService $volumes,
        private CheckIfProductFormatExistService $checkIfProductFormatExist,
        private CreateCsvFileService $createCsvFile,
        private ReadCsvFileService $readCsvFile
    ) {
        $this->nicotines = $nicotines;
        $this->products = $products;
        $this->productsFormats = $productsFormats;
        $this->ranges = $ranges;
        $this->volumes = $volumes;
        $this->checkIfProductFormatExist = $checkIfProductFormatExist;
        $this->createCsvFile = $createCsvFile;
        $this->readCsvFile = $readCsvFile;
    }

    /**
     * Extract products from a CSV [format: code_art, label] and store each item in DB
     *
     * @param string $tmpName
     * @return void
     */
    public function execute(string $tmpName) {

        ini_set('auto_detect_line_endings', TRUE);
        $this->createCsvFile->csvReplaceDelimiters($tmpName);
        $datas = $this->readCsvFile->extractDatasFromCsv($tmpName);
        
        if(preg_match('/^[^ ].* .*[^ ]$/', $datas[0][0])) {
            unset($datas[0]);
        }
        
        $products = $this->getAdditionnalInfos($datas);
        
        foreach($products as $product) {
            $this->products->store($product);
        } 
    }

    /**
     * Loop through $datas to identify Range, Volume and nicotine for each product
     *
     * @param array $datas
     * @return void
     */
    private function getAdditionnalInfos(array $datas) {
        $result = array();

        foreach ($datas as $data ) {
            if (is_array($data) && count($data) > 0) {
                $codeArt = $data[0];
                preg_match('(\d+)', $codeArt, $digitPartFromCodeArt);
                preg_match('(\D+)', $codeArt, $letterPartFromCodeArt);

                $tmp['ranges_id'] = $this->getProductRange($letterPartFromCodeArt[0]);
                $tmp['name'] = addslashes($data[1]);
                $tmp['name_shorten'] = $this->getProductShortName($data[1], $tmp['ranges_id']);
                $tmp['code_art'] = $codeArt;
                $tmp['volumes_id'] = $this->getProductVolume($digitPartFromCodeArt[0], $letterPartFromCodeArt[0]);                
                $tmp['nicotines_id'] = $this->getProductNicotine($digitPartFromCodeArt[0]);                
                $tmp['specificPrice'] = 0;
                $tmp['productType_id'] = $this->ranges->find($tmp['ranges_id'])->type;
                $tmp['productTypeVolumesNicotines_id'] = $this->checkIfProductFormatExist->execute($tmp['productType_id'], $tmp['volumes_id'], $tmp['nicotines_id']);  

                
                array_push($result, $tmp);
            }
        }

        return $result;
    }

    /**
     * Get the real name of the product
     * 
     * @param string $fullName ideal format : [*Full name of the range* *Name of the product* *nicotine and quantity*]
     * @param integer $rangeId
     * @return string
     */
    private function getProductShortName(string $fullName, int $rangeId):string {
        $ranges = $this->ranges->findAll(true, ['range']);
        $shorten_name = explode(strtolower($ranges[$rangeId]['range']), strtolower($fullName));

        if(count($shorten_name) > 1) {
            unset($shorten_name[0]);
            $token = '/[0-9]+([[:space:]]?mg)/i';
            $shorten_name = ucfirst(trim(preg_split($token, $shorten_name[1])[0]));
            
            return $shorten_name;
        }
        
        return $fullName;   
    }
    
    /**
     * Search range id of product in $ranges based on $letters and assign to $tmp
     *
     * @param string $codeFam
     * @return string
     */
    private function getProductRange(string $codeFam):int {
        $ranges = $this->ranges->findAll(true, ['code_fam']);
        $arrayCodesFam = array_column($ranges, 'code_fam');

        if($found_index = array_search($codeFam, $arrayCodesFam)) {
            return array_values($ranges)[$found_index]['id'];
        } else {
            return SELF::DEFAULT_RANGE;
        }
    }

    /**
     * Define volume of product
     *
     * @param string $digitPartFromCodeArt
     * @param string $range The letter part of a code article(eg. FRZ)
     * @return integer|string
     */
    private function getProductVolume(string $digitPartFromCodeArt, string $range):int|string {
        $referenceVolume = substr($digitPartFromCodeArt[0], 0, 1);

        if(
            isset(self::VOLUME_EXCEPTIONS[$range]) &&
            (strpos($digitPartFromCodeArt, self::VOLUME_EXCEPTIONS[$range]['reference']) === 0)
        ) {
            $volume = $this->volumes->findByValue(self::VOLUME_EXCEPTIONS[$range]['volume']); 
        }

        if(isset(self::VOLUME_DATAS[$referenceVolume])){
            $volume = $this->volumes->findByValue(self::VOLUME_DATAS[$referenceVolume]); 
        } else {
            $volume = $this->volumes->findByValue(self::DEFAULT_VOLUME); 
        }

        return $volume->id;

    }

    /**
     * Get nicotine level for a product reference
     *
     * @param string $digitPartFromCodeArt
     * @param integer|string $volume
     * @return integer
     */
    private function getProductNicotine(string $digitPartFromCodeArt):int {
        if(!preg_match('(\d+)', $digitPartFromCodeArt)) {
            $nicotine = $this->nicotines->findByValue(0);
        }
        
        if($this->nicotines->findByValue(intval(substr($digitPartFromCodeArt, -2)))) {
            $nicotine = $this->nicotines->findByValue(intval(substr($digitPartFromCodeArt, -2)));
        } else {
            $nicotine = $this->nicotines->findByValue(0);
        }
        
        return $nicotine->id;
    }

}