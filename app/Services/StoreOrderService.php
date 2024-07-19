<?php

namespace App\Services;

use App\Exceptions\WithArgumentException;

use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderProduct;

use App\Services\ContactService;
use App\Services\CreateCsvFileService;
use App\Services\ProductService;
 
class StoreOrderService {

    public function __construct(
        private ContactService $contacts,
        private CreateCsvFileService $createCsvFile,
        private ProductService $products
    ) {
        $this->contacts = $contacts;
        $this->createCsvFile = $createCsvFile;
        $this->products = $products;
    }

    /**
     * Create and store order in DB and in files
     *
     * @param array $order
     * @return string
     */
    public function execute(array $order): string {
        $customer = $this->contacts->find($order['customerId']);
        $order['products'] = $this->getProductsWithQuantityFromOrder($order['products']);
               
        if(empty($order['products'])) {
            throw new WithArgumentException("Une commande ne peut être vide", '/');
        }

        try {
            $orderDatasFromDB = $this->storeOrder($order);
            $filename = $this->registerCsvFile($customer, $orderDatasFromDB['id'], $orderDatasFromDB['datas'], $order['products']);
                        
            return $filename;
        } catch (\WithArgumentException $e) {
            throw new WithArgumentException($e->getMessage, $e->getAdditionnalInfo());
        }

        
    }

    private function getProductsWithQuantityFromOrder (array $orderProducts): array {
        foreach($orderProducts as $id => $quantity) {
            if($quantity) {
                $product = $this->products->find($id);
                $datas[$id] = [
                    'name' => $product->name,
                    'code_art' => $product->code_art,
                    'quantity' => $quantity
                ];
            }
        }

        return $datas;
    }

    /**
     * Insert new order in database and return its ID
     *
     * @param Array $order
     * @return integer
     */
    private function storeOrder (array $datas): array {
        $orderDatas = [
            'customer_id' => $datas['customerId'],
            'notes' => $datas['notes'],
            'csvToken' => time().$datas['_token'],
            'total' => floatval($datas['total'])
        ];

        try {
            $order = new Order($orderDatas);
            $order->save();

            $this->addProductsToOrder($datas['products'], $order->id);
        } catch(\WithArgumentException $e) {
            throw new WithArgumentException($e->getMessage, '');
        }

        return ['id' => $order->id, 'datas' => $orderDatas];
    }

    /**
     * Attribute product to order in database
     *
     * @param Array $products
     * @param integer $id
     * @return void
     */
    private function addProductsToOrder(Array $products, int $id) {

        foreach($products as $key => $product) {
            if($product) {
                
                $datas = [
                    'order_id' => $id,
                    'product_id' => $key,
                    'quantity' => $product['quantity']
                ];

                $orderProduct = new OrderProduct($datas);
                $orderProduct->save();
            }
        }
    }

    /**
     * Create and save CSV file
     *
     * @param Contact $customer - Customer informations from DB request
     * @param integer $orderId
     * @param array $orderDatas - Contains, at least ['notes', 'total', 'csvToken']
     * @param array $orderProducts
     * @return void
     */
    private function registerCsvFile(
        Contact $customer, 
        int $orderId,
        array $orderDatas,
        array $orderProducts
    ) {
        $csvDatas = [];
        array_push($csvDatas, $customer->getAttributes());
        array_push($csvDatas, ['notes' => $orderDatas['notes']]);
        array_push($csvDatas, ['total' => $orderDatas['total']]);
        array_push($csvDatas, $orderProducts);

        $filename = str_replace(' ', '_', 'Commande '. $orderId . ' - ' . $customer->company).'-'.$orderDatas['csvToken'];
        $path = '../storage/app/public/csv/orders/'.$filename.'.csv';

        try {
            $this->createCSVOrder($csvDatas, $filename, $path);
            return $filename;
        } catch(\WithArgumentException $e) {
            throw new WithArgumentException($e->getMessage, $e->getAdditionnalInfo());
        }


    }

    /**
     * Create a CSV document and store or download it, 
     * depending on the path
     *
     * @param array $datas
     * @param string $filename
     * @param string $path : eg. '../storage/app/public/csv/orders/myfile.csv'
     * @return void
     */
    private function createCSVOrder(
        array $datas, 
        string $filename, 
        string $path
    ) {
        $csvHeading = [
            'newContact' => 'Nouveau contact ?',
            'collaborator' => 'Code collaborateur',
            'famille' => 'Code famille de compte',
            'gender' => 'Civilité',
            'firstname' => 'Prénom',
            'lastname' => 'Nom de famille',
            'company' => 'Entreprise',
            'function' => 'Fonction',
            'mobile' => 'Tel. (mobile)',
            'phone' => 'Tel. (fixe)',
            'email' => 'E-mail',
            'adress' => 'Adresse 1',
            'adressBis' => 'Adresse 2',
            'zipcode' => 'Code Postal',
            'country' => 'Pays',
            'siret' => 'SIRET',
            'tva' => 'Numéro de TVA',
            'notes' => 'Notes',
            'total' => 'Total de la commande (en '. setting('settings')->get('currency', '€') . ')'
        ];
        $csvDelimiter = ';';

        $products = end($datas);

        $datas = array_merge(...$datas);
        foreach($csvHeading as $key => $label) {
            $orderInfos[$label] = $datas[$key];
        }

        $this->createCsvFile->setHeaderCSV($filename);
        if(!$filename) {
            throw new WithArgumentException("File not found", '/');
        }
        
        $output = fopen($path, 'w');
        
        if(!$output) {
            throw new WithArgumentException("File open failed", '/');
        }
        
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        $this->createCsvFile->insertDatasInCSV($orderInfos, $output, 'inline');
        fputcsv($output, [' ', ' ', ' '], $csvDelimiter);
        fputcsv($output, ['Désignation', 'Code Article', 'Quantité'], $csvDelimiter);
        $this->createCsvFile->insertDatasInCSV($products, $output);
        fclose($output);  
    }
}