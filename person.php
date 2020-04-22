<?php
require 'mysql.php';
require 'config.php';

class Person{
   public $ID ;
   public $FirstName ;
   public $LastName ;
   public $PhoneNumber ;
   public $Email ;
   public $Age ;
   public $Gender ;
   public $Password;
   use mysql{
        mysql::__construct as private __mysqlconstruct;
    }
    public function __construct(){
        global $config;
        //call trait constructor
       // parent::__construct($config);
       $this->__mysqlconstruct($config);
    }
   public function Login() {
       
   }
   public function Logout() {
       
   }
   /* public function ViewPackages(){
        return $result=$this->select('Packages','','*','');
    }*/
}