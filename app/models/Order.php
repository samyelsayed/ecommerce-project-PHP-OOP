<?php

include_once __DIR__.'/../database/config.php';
 include_once __DIR__.'/../database/operations.php';
class Order extends config implements operations {

    private $id;
    private $payment_method;
    private $total_price;
    private $status;
    private $lat;
    private $long;
    private $long_treated_at;
    private $created_at;
    private $updated_at	;
    private $delivered_at;
    private $address_id;
    private $coupon_id;

    public function create () {

    }
    public function read () {
        
    }
    public function update () {
        
    }
    public function delete () {
        
    }
  
    public function mostedProductOrder () {
         $query = "
        SELECT 
            `products`.`id`,
            `products`.`name_en`,
            `products`.`price`,
            `products`.`desc_en`,
            `products`.`image`,
            COUNT(`order_product`.`product_id`)
            FROM `products`
            JOIN `order_product`
            ON `products`.`id` = `order_product`.`product_id`
            WHERE `products`.`status` = 1
            GROUP BY `products`.`id`
            ORDER BY COUNT(`order_product`.`product_id`) DESC
            LIMIT 4 ";
             return $this->runDQL($query);
    }


}