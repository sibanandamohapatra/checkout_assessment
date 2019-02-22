<?php

class Product {

    public function __construct(){
        $this->url = APPROOT . '/data.json';
        $json_data = file_get_contents($this->url);
        $this->record = json_decode($json_data);
        
    }

    public function getAllProducts(){
        return $this->record->products;
    }

    public function getCheckout($data_post){
        $data = [];
        $products = $this->record->products;
        //print_r($products);exit;
        $mbs_qnt = $vga_qnt = 0;
        foreach($data_post["quantity"] as $key => $val){
            if(!empty($key) && $key == "ipd" && !empty($val) && $val != 0){
                $data[$key]["qnt"] = $val;
                $data[$key]["name"] = $products[0]->name;
                $net_price = $val * $products[0]->price;
                if($val > 4){
                    $net_price = $net_price - 499.99;
                }
                $data[$key]["price"] = $net_price;
            }
            else if(!empty($key) && $key == "atv"&& !empty($val) && $val != 0){
                $data[$key]["qnt"] = $val;
                $data[$key]["name"] = $products[2]->name;
                $net_price = $val * $products[2]->price;
                $net_price = $net_price - ( (int)($val / 3) * $products[2]->price);
                $data[$key]["price"] = $net_price;
            }
            else if(!empty($key) && $key == "mbp" && !empty($val) && $val != 0){
                $mbs_qnt = $data[$key]["qnt"] = $val;
                $data[$key]["name"] = $products[1]->name;
                $net_price = $val * $products[1]->price;
                $data[$key]["price"] = $net_price;
            }
            else if(!empty($key) && $key == "vga" && !empty($val) && $val != 0){
                if($mbs_qnt == $val || $mbs_qnt > $val){
                    $vga_qnt = 0;
                }else if($mbs_qnt < $val){
                    $vga_qnt = $val - $mbs_qnt;
                }     
                $data[$key]["name"] = $products[3]->name;
                $net_price = $vga_qnt * $products[3]->price;
                $data[$key]["price"] = $net_price;
                $data['vga']["qnt"] = $val;
            }
        }
        return $data;
    }

    
}
