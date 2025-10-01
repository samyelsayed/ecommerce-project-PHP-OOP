<?php


include_once __DIR__.'/../database/config.php';
include_once __DIR__.'/../database/operations.php';
class User extends config implements operations {
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $phone;
    private $gender;
    private $email_verified_at;
    private $code;
    private $status;
    private $image;
    private $created_at;
    private $updated_at;

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password =sha1($password);
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setEmailVerifiedAt($email_verified_at) {
        $this->email_verified_at = $email_verified_at;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getEmailVerifiedAt() {
        return $this->email_verified_at;
    }

    public function getCode() {
        return $this->code;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getImage() {
        return $this->image;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function create() {
        $query = "INSERT INTO users (first_name,last_name,email,phone,password,gender,code)VALUES
         ('$this->first_name','$this->last_name','$this->email','$this->phone',
         '$this->password','$this->gender',$this->code)";
         return $this->runDml($query);
    }

    public function read() {
        
    }
    public function update() {
        
    }
    public function delete() {
        
    }

    public function checkcode() {
        $query = "SELECT * FROM users WHERE email = '$this->email' AND code = '$this->code'";
        return $this->runDQL($query);
    }

    public function verfiedUser() {
        $query = "UPDATE users SET email_verfied_at = '$this->email_verified_at', status = $this->status WHERE email = '$this->email'";

        return $this->runDML($query);
        }
}





 