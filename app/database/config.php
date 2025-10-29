<?php
 

 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 class config {
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $databasename = 'smasem_ecommerce';
    private $con;
  public function __construct() {
    $this->con = new mysqli($this->hostname, $this->username, $this->password, $this->databasename);
    if ($this->con ->connect_error) {
        die("Connection failed: " .$this->con ->connect_error);
    }
    echo " ";
  }


  public function runDML(string $query) : bool
  {

    $result = $this->con->query($query);
    if($result) {
        return true;
    } else {
        return false;
    }
  }


   public function runDQL(string $query) 
    {
        $result = $this->con->query($query);
        if($result->num_rows > 0){
            return $result;
        }
        return [];
    }



}



// <?php
 
// class Config {
//     private $hostname = 'localhost';
//     private $username = 'root';
//     private $password = '';
//     private $databasename = 'ayhaga';

//     public function __construct() {
//         $con = new mysqli($this->hostname, $this->username, $this->password, $this->databasename);
        
//         if ($con->connect_error) {
//             die("Connection failed: " . $con->connect_error);
//         }
//         echo "Connected successfully";
//     }
// }

// $x = new Config();



