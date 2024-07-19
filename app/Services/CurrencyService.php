<?php

namespace App\Services;

use App\Models\Currencies;

use Sajadsdi\LaravelSettingPro\Support\Setting;
 
class CurrencyService {
    
    public function findAll() {
        
        return Currencies::all();

    }

    public function update(string $data) {

        try {
            Setting::select('settings')->set('currency', $data);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

}