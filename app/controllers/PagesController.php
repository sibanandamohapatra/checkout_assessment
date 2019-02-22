<?php

    class PagesController extends Controller {
        public function __construct(){
            $this->productModel = $this->model('Product');
        }

        public function actionIndex(){
            try{
                if( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST)){
                    // Sanitize POST array
                    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                    $result = $this->productModel->getCheckout($_POST);
                    $data = [
                        'title' => 'Checkout',
                        "products" => $result
                    ];
                    $this->view('pages/checkout', $data);
                }
                else{
                    $record = $this->productModel->getAllProducts();
                    $data = [
                        'title' => 'Checkout',
                        "products" => $record
                    ];
                    
                    $this->view('pages/index', $data);
                }
            }
            catch(\Exception $e) {
                echo $e->getMessage();exit;
            }
            
        }

        public function actionCheckout(){
            
        }
    }
