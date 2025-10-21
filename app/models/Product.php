<?php


include_once __DIR__.'/../database/config.php';
include_once __DIR__.'/../database/operations.php';
class Product extends config implements operations {
    private $id,
        $name_en,
        $name_ar,
        $price,
        $quantity,                 //اعملهم السيترز و الجيترز
        $desc_en,
        $desc_ar,
        $image,
        $code,
        $status,
        $brand_id,
        $subcategory_id,
        $created_at,
        $updated_at;

    public function create () {

    }
    public function read () {
        $query = "SELECT id,name_en,price,desc_en,image from productus WHERE status=$this->status "
    }
    public function update () {
        
    }
    public function delete () {
        
    }
  

}