<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProductTypesController;

use App\Services\CurrencyService;
use App\Services\ProductTypeService;
use App\Services\NicotineService;
use App\Services\VolumeService;

use Illuminate\Http\Request;
use App\Http\Requests\CurrencyRequest;

class SettingsController extends Controller
{

    public function __construct(
        private CurrencyService $currencies,
        private ProductTypeService $productTypes,
        private NicotineService $nicotines,
        private VolumeService $volumes
    ) {
        $this->currencies = $currencies;
        $this->productTypes = $productTypes;
        $this->nicotines = $nicotines;
        $this->volumes = $volumes;
    }

    public function render() {

        foreach($this->currencies->findAll() as $currency) {
            $currencies[$currency->label] = $currency->label;
        }

        
        $tables['productType'] = $this->productTypes->getDatasToDisplay();
        $tables['volumes'] = $this->volumes->getDatasToDisplay();
        $tables['nicotines'] = $this->nicotines->getDatasToDisplay();
        

        return view('dashboard.settings',['currencies' => $currencies, 'tables' => $tables]);
    }

    public function updateCurrency(CurrencyRequest $request) {

        try {
            $this->currencies->update($_POST['currency']);
    
            return redirect()->route('settings')->with(['success' => 'Devise mis à jour.']);
        } catch(\Exception $e) {
            return redirect()->route('settings')->with(['error' => $e->getMessage()]);
        }

    }
}
