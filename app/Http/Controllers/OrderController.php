<?php

namespace App\Http\Controllers;

use App\Exceptions\WithArgumentException;

use App\Services\ContactService;
use App\Services\ProductService;
use App\Services\RangeService;
use App\Services\StoreOrderService;

use App\Services\GetAllDatasRelatedToProductsService;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\OrderRequest;

use Illuminate\Database\Eloquent\Collection;

class OrderController extends Controller
{

    public function __construct(
        private ContactService $contacts,
        private ProductService $products,
        private RangeService $ranges,
        private GetAllDatasRelatedToProductsService $getAllDatasRelatedToProducts,
        private StoreOrderService $storeOrder,
    ) {
        $this->contacts = $contacts;
        $this->products = $products;
        $this->ranges = $ranges;
        $this->getAllDatasRelatedToProducts = $getAllDatasRelatedToProducts;
        $this->storeOrder = $storeOrder;
    }

    /**
     * Display Form for new order
     *
     * @return View
     */
    public function render(): View {

        $customers = $this->contacts->findAll(true, ['lastname', 'company', 'email']);      
        $ranges = $this->ranges->findAllActive(true, ['range', 'type_name']);
        $products = $this->products->findAllActive(true);

        $productsCollection = $this->products->findAllActive();
        $datas =  $this->getAllDatasRelatedToProducts->execute($productsCollection);

        $contentTableHead = $this->getTableHeadSentence($productsCollection);

        $datas = array_replace_recursive($datas, $contentTableHead);
            
        return view('order', [
            'customers' => $customers, 
            'ranges'    => $ranges, 
            'products'  => $products, 
            'datas'     => $datas
        ]);
    }

    /**
     * Secure and store datas from form
     *
     * @param OrderRequest $request
     * @return route
     */
    public function add (OrderRequest $request) {
        $order = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        
        try {
            $filename = $this->storeOrder->execute($order);

            return redirect()->route('form-validation')->with(['filename' => $filename, 'route' => 'orders', 'file' => 'csv']);
        } catch (\WithArgumentException $e) {
           $error = $e->getMessage();
           $filename = $e->getAdditionnalInfo();
           
            return redirect()->route('form-error')->with(['error' => $error, 'filename' => $filename, 'route' => 'orders', 'file' => 'csv']);
        }
    }

    private function getTableHeadSentence(Collection $products):array {

        foreach($products as $product) {

            $volume = $product->volume;
            $rangeId = $product->range_id;

            switch ($product->type) {
                case 'eliquide':
                    $sentence = 'Flacon de '.$volume.'mL';
                    break;
                case 'esalt':
                    $sentence = 'Sel de nicotine ('.$volume.'mL)';     
                    break;
                case 'diy':
                    $sentence = 'DIY ('.$volume.'mL)';
                    if($rangeId === 9) {
                        $sentence = $volume . 'mL';
                    }
                    break;
                case 'pods':
                    $sentence = $volume . 'mL';
                    if($volume == '0') {
                        $sentence = 'Accessoires';
                    }
                    break;
                default:
                    $sentence = $volume . 'mL';
                    break;
            }

            $datas[$product->ranges_id]['contentTableHead'][$product->type][$product->volume] = $sentence;
            $datas[$product->ranges_id]['contentTableHead'][$product->type]['volume'] = $volume;
            $datas[$product->ranges_id]['contentTableHead'][$product->type]['type'] = $product->type;
        } 

        return $datas;
    }

}
