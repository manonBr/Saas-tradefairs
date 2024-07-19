<?php

namespace App\Http\Controllers;

use App\Services\NicotineService;
use App\Services\ProductService;
use App\Services\ProductTypeService;
use App\Services\RangeService;
use App\Services\VolumeService;

use App\Services\CreateArrayForSelectService;
use App\Services\DeleteDataService;
use App\Services\UpdateStatusService;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    public function __construct(
        private NicotineService $nicotines,
        private ProductService $products,
        private ProductTypeService $productTypes,
        private RangeService $ranges,
        private VolumeService $volumes,
        private CreateArrayForSelectService $createArrayForSelect,
        private DeleteDataService $deleteData,
        private UpdateStatusService $updateStatus
    ) {
        $this->nicotines = $nicotines;
        $this->products = $products;
        $this->productTypes = $productTypes;
        $this->ranges = $ranges;
        $this->volumes = $volumes;
        $this->createArrayForSelect = $createArrayForSelect;
        $this->deleteData = $deleteData;
        $this->updateStatus = $updateStatus;
    }

    /**
     * Display product form
     *
     * @return view
     */
    public function render($id = null){
        $ranges = $this->ranges->findAll();
        $rangesSelect = $this->createArrayForSelect->execute($ranges, 'range');
        $rangesDataset = $this->createRangesDataset($ranges, 'type');
        $nicotines = $this->createArrayForSelect->execute($this->nicotines->findAll());
        $volumes = $this->createArrayForSelect->execute($this->volumes->findAll());
        $productTypes = $this->createArrayForSelect->execute($this->productTypes->findAll());
        $product = [];

        if($id) {
            $product = $this->products->find($id);
        }

        return view('dashboard.forms.product', 
            ['ranges' => $rangesSelect, 
            'rangesDataset' => $rangesDataset, 
            'volumes' => $volumes, 
            'nicotines' => $nicotines, 
            'product' => $product, 
            'productTypes' => $productTypes]);
    }

    
    public function add(ProductRequest $request) {
        $product = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                
        try {
            $this->products->store($product);
            
            return redirect()->route('products')->with(['success' => 'Nouveau produit enregistré avec succès !']);
        } catch (\Exception $e) {
            return redirect()->route('product-form')->with(['error' => $e->getMessage()]);
        }
    }

    public function update(ProductRequest $request, int $id) {
        $datas = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_BOOLEAN);
        $datas['active'] = $request->boolean('active');
        unset($datas['_token']);

        try {
            $this->products->update($datas, $id);
            return redirect()->route('products')->with(['success' => 'Produit mis à jour !']);
        } catch(\Exception $e) {
            return redirect()->route('product-form', ['id' => $id])->with(['error' => $e->getMessage()]);
        }
    }

    public function updateStatus(int $id, int $currentStatus) {
        try {
            $this->updateStatus->execute($this->products, $id, $currentStatus, true);
            return ['active' => !boolval($currentStatus), 'success' => 'Statut du produit mis à jour !'];
        } catch(\Exception $e) {
            return ['active' => $currentStatus, 'error' => $e->getMessage()];
        }
    }

    public function delete(int $id) {
        try{
            $this->deleteData->execute($this->products, $id);
            return redirect()->route('products')->with(['success' => 'Produit supprimé']);
        } catch(\Exception $e) {
            return redirect()->route('products')->with(['error' => $e->getMessage()]);
        }
        
    }

    public function createRangesDataset(Collection $ranges, string $name) {
        $result['name'] = $name;
        foreach($ranges as $range) {
            $result[$range->id] = $range->type_name;
        }

        return $result;
    }
 
}
