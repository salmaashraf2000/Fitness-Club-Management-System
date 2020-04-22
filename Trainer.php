<?php

class Trainer extends Person{
    
    public $TimeStartingShift;
    public $TimeEndingShift;
    use mysql
    {
        mysql::__construct as private __mysqlconstruct;
    }
    public function __construct()
    {
        global $config;
       $this->__mysqlconstruct($config);
    }
}
