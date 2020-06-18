<?php

session_start();

require_once 'Person.php';
  
        $person=new Person();
        $person->Logout();
        
        header("Location:index.php");             
 
   
?>