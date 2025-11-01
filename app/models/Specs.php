<?php

include_once __DIR__.'/../database/config.php';
 include_once __DIR__.'/../database/operations.php';
class Specs extends config implements operations {

    private $id;
    private $name_en;
    private $name_ar;

    public function create () {

    }
    public function read () {
        
    }
    public function update () {
        
    }
    public function delete () {
        
    }
  



 

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name_en
     */ 
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */ 
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */ 
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */ 
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

        return $this;
    }


        public function getSpecs () {
                $query =  "SELECT
                `products_specs`.`product_id`,
                CONCAT(
                    `specs`.`name_en`,
                    ' : ',
                    `products_specs`.`value_en`
                ) AS `specs_en`
            FROM
                `specs`
            JOIN
                `products_specs` ON `specs`.`id` = `products_specs`.`spec_id`
            WHERE
                `products_specs`.`product_id` = $this->id;
            ";
        return $this->runDQL($query);

    }
}