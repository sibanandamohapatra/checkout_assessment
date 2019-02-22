<?php
    /*
    * App Core Class
    * Create URL & loads core controller
    * URL FORMAT - /controller/method/params
    */

    class Core {
        protected $currentController = 'PagesController';
        protected $currentMethod = 'actionIndex';
        protected $params = [];

        public function __construct(){
            //print_r($this->getUrl());
            $url = $this->getUrl();

            // Look in controllers for first time
            if(file_exists('../app/controllers/' . ucwords($url[0]) . 'Controller.php')){
                $this->currentController = ucwords($url[0]) . 'Controller';
                // unset o index
                unset($url[0]);
            }

            // Require the controller
            require_once '../app/controllers/' . $this->currentController . '.php';
            // Instantiate the controller class
            $this->currentController = new $this->currentController;

            // Check for second part of URL
            if(isset($url[1])){
                $method = 'action' . str_replace(' ','',ucwords(str_replace("-"," ",trim($url[1]))));
                // Check to see if method exist in controller
                if(method_exists($this->currentController, $method)){
                    $this->currentMethod = $method;
                    // Unset 1 index
                    unset($url[1]);
                }
            }

            // Get Params
            $this->params = $url ? array_values($url) : [];

            // call a cllback with a array of params
            call_user_func_array([$this->currentController,$this->currentMethod], $this->params);
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url ,FILTER_SANITIZE_URL);
                $url = explode('/',$url);
                return $url;
            }
            
        }
    }