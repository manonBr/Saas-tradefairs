<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\RangeService;


class DashboardController extends Controller
{

    public function __construct(
        private ProductService $products,
        private RangeService $ranges
    ) {
        $this->products = $products;
        $this->ranges = $ranges;
    }

    public function render() {

        $productsUnofficial = $this->products->findAllActiveUnofficial(true);
        $ranges = $this->ranges->findAll(true, ['range']);

        // dd($productsUnofficial[18]);

        return view('dashboard.dashboard',['ranges' => $ranges, 'productsUnofficial' => $productsUnofficial]);
        
    }

}
