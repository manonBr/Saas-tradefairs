<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;

use App\Services\ContactService;
use App\Services\FileService;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService {

    public function __construct(
        private ContactService $contacts,
        private FileService $files
    ) {
        $this->contacts = $contacts;
        $this->files = $files;
    }

    public function find(int $id): Order {
        return Order::find($id);
    }

    public function findAll(): Collection {

        $orders = Order::orderBy('created_at', 'desc')->get();

        $ordersItems = DB::table('order')
        ->join('order_products', 'order.id', '=', 'order_products.order_id')
        ->join('products', 'order_products.product_id', '=', 'products.id')
        ->get()
        ->groupBy('order_id');

        foreach($orders as $key => $order) {
            if(!isset($ordersItems[$order->id])) {
                unset($orders[$key]);
                continue;
            }
            $order['items'] = $ordersItems[$order->id];
            $order['customer'] = $this->contacts->find($order->customer_id);
        }

        return $orders;
    }

    public function delete(int $id): bool {
        $order = $this->find($id);
        $customer = $this->contacts->find($order->customer_id);
        $response = false;
        
        OrderProduct::where('order_id', $id)->delete();
        
        if($order->delete()) {
            $response = true;
        }
        
        $filename = str_replace(' ', '_', 'Commande '. $order->id . ' - ' . $customer->company).'-'.$order->csvToken;
        $this->files->delete('csv', 'orders', $filename);

        return $response;
    }
    
    public function deleteAll(): bool {
        $response = false;

        OrderProduct::truncate();

        if(DB::table('order')->delete()) {
            $response = true;
        }
        $this->files->deleteAll('csv/orders');
        
        return $response;
    }

}