<?php

include_once __DIR__ . '/../database/config.php';
 class Validation{ 


      private $name;
      private $value;
    //وحدنا اسماء البراميتر في الفانكشن


      public function __construct($name, $value)
      {
        $this->name = $name;
        $this->value = $value;
      }


    public function required()
   {
    return empty($this->value) ? "The $this->name field is required." : "";
   }

    public function regex($pattern)
    {
       return preg_match($pattern ,$this->value ) ?  "" :$this->name . " is not valid.";
    }
//     public function unique($table)
//     {
//        $query = "SELECT * FROM $table WHERE `$this->name` = '$this->value'";

//        $config = new config();
//        $result = $config->runDQL($query);
//        return empty($result) ? "" : "The {$this->name} already exists.";
//     }

//        public function confirmed( $valueConfirmation)
//       {
//          return ($this->value === $valueConfirmation) ? "" : "The $this->name does not match.";

//  }
  public function unique($table)
    {
        $query = "SELECT * FROM `$table` WHERE `$this->name` = '$this->value'";
        
        $config = new config;
        $result = $config->runDQL($query);

        return (empty($result)) ? "" : "this $this->name is already exists";
    }

    public function confirmed($valueConfirmation) 
    {
        return ($this->value == $valueConfirmation) ? "" : "$this->name Not Confirmed";
    }
}