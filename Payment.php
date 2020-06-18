<?php
class Payment{
    
    
    private $Cash;
    private $Electronic;
     public function __construct(){
     	$this->Cash=False;
     	$this->Electronic=False;
     }

     public function getCash()
     {
         return $this->Cash;
     }

     public function getElectronic() 
     {
         return $this->Electronic;
     }

     public function setCash($Cash) 
     {
         $this->Cash = $Cash;
     }

     public function setElectronic($Electronic) 
     {
         $this->Electronic = $Electronic;
     }


     
}