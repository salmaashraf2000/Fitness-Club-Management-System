<?php

session_start();

require_once 'Person.php';
  

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
        $person=new Person();
        $person->Logout();
        
        //header(" .php");             
 
}
   
?>