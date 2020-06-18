<?php

require_once 'mysql.php';
require_once 'config.php';

class Validation {
    
    use mysql{
        mysql::__construct as private __mysqlconstruct;
    }
    
    public function __construct()
    {
        global $config;
        
       $this->__mysqlconstruct($config);
    }
    
    public function test_input($input) 
    {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
   }
   
   public function Name($name)
   {
       $nameErr="";
       if (! (isset($name) && !empty($name))) 
      {
    
          $nameErr='*First name is required';
      } else 
      {
    
          // check if name only contains letters and whitespace
          if (!preg_match("/^[a-zA-Z ]*$/",$name))
          {
               
                $nameErr='*First name must contain letters only';
          }
       }
       return $nameErr;
   }
  
   //check if email already exists
    public function CheckIfEmailExists($email){
        $table='UsersInformation';
        $this->select($table,"Email='$email' ");
        if($this->countRows()==0)
        {
            
            //email does not exist
            return false;
        } else 
        {
            
            //email exists
            return true;
        }
    }
   public function Email($email)
   {
        $emailErr="";
        if (! isset($email)) 
        {

            $emailErr='*Email is required';
        } else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            
            $emailErr='*Email not valid';
        }else if($this->CheckIfEmailExists($email)==true)
        {
            $emailErr='*Email already exists';
        }
        return $emailErr;
   }
   
   public function EmailLogin($email)
   {
        $emailErr="";
        if (! isset($email)) 
        {

            $emailErr='*Email is required';
        } else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            
            $emailErr='*Email not valid';
        }
        return $emailErr;
   }
   
   public function Password($password)
   {
       
       $passwordErr="";
       if (! (isset($password) && strlen($password)>7)) 
        {
    
            $passwordErr='*Password must be 8 charecters or more';
        }
        return $passwordErr;
   }
   
   
   public function PhoneNumber($phone)
   {
       $PhoneErr="";
       if (! (isset($phone) && !empty($phone))) 
       {
    
           $PhoneErr='*Phone Number is required';
       }else if(strlen ($phone)!=11)
       {
           $PhoneErr='*Phone Number must be 11 digits';
       }
       return $PhoneErr;
   }
   
   public function Radio($radio)
   {
       $Err="";
        if (empty($radio)) 
        {
           $Err='*This field is required field';
        }
        return $Err;
   }
   
   public function Age($age)
   {
       $AgeErr="";
       if (! (isset($age) && !empty($age))) 
       {
    
          $AgeErr='*Age is required field';
       }
       return $AgeErr;
   }
   
   public function Number($Input)
   {
       $Err="";
       if (! (isset($Input) && !empty($Input)) && $Input!=='0') 
       {
    
           $Err='*This field is required';
        } 
        return $Err;
   }
   public function Text($Input)
   {
       $Err="";
       if (! (isset($Input) && !empty($Input))) 
       {
    
           $Err='*This field is required';
        } 
        return $Err;
   }
}
