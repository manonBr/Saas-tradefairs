<?php

namespace App\Http\Controllers;

use App\Services\ExtractProductsFromFileService;
use App\Services\ProductService;
use App\Services\RangeService;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function __construct(
        private ExtractProductsFromFileService $extractProductsFromFile,
        private ProductService $products,
        private RangeService $ranges
    ) {
        $this->extractProductsFromFile = $extractProductsFromFile;
        $this->products = $products;
        $this->ranges = $ranges;
    }

    /**
     * Display all the products
     *
     * @return view
     */
    public function render() {
        $products = $this->products->findAll(true);
        $ranges = $this->ranges->findAll(true, ['range']);

        return view('dashboard.products', ['products' => $products, 'ranges' => $ranges]);
    }


    public function upload(Request $request) {
        $tmpName = $_FILES["products"]['tmp_name'];

        try {
            $this->extractProductsFromFile->execute($tmpName);

            return redirect()->route('products')->with(['success' => 'Import réalisé avec succès']);
        } catch(\Exception $e) {
            return redirect()->route('products')->with(['error' => $e->getMessage()]);
        } 
    }
    
    public function delete() {
        
        try{
            $this->products->deleteAll();

            return redirect()->route('products');
        } catch(\Exception $e) {
            return redirect()->route('products')->with(['error' => $e->getMessage()]);
        }
       
        
    }

}
