<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FileController;

use App\Services\OrderService;

use ZipArchive;

class OrdersController extends Controller
{

    public function __construct(private OrderService $orders) {
        $this->orders = $orders;
    }

    public function display() {
        $orders = $this->orders->findAll();
        return view('orders', ['orders' => $orders]);
    }

    public function download() {
        $path = 'csv/orders';
        $zipFileName = 'commandes_salon.zip';

        try {
            return FileController::downloadAll($path, $zipFileName);

        } catch(\Exception $e) {
            return redirect()->route('orders')->with(['error' => $e->getMessage()]);
        }        
    }

    public function delete(int $id = null) {
        $id = strip_tags($id);
        $response = false;
        
        if ($id) {
            $response = $this->orders->delete($id);
        } else {
            $response = $this->orders->deleteAll();
        }

        return redirect()->route('orders')->with(['response' => $response]);
        
    }
}
