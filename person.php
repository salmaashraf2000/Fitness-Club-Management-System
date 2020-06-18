<?php
require_once 'mysql.php';
require_once 'config.php';

class Person{
   protected $ID ;
   protected $FirstName ;
   protected $LastName ;
   protected $PhoneNumber ;
   protected $Email ;
   protected $Age ;
   protected $Gender ;
   protected $Password;
   public function getFirstName() {
       return $this->FirstName;
   }

   public function getLastName() {
       return $this->LastName;
   }

   public function getPhoneNumber() {
       return $this->PhoneNumber;
   }

   public function getEmail() {
       return $this->Email;
   }

   public function getAge() {
       return $this->Age;
   }

   public function getGender() {
       return $this->Gender;
   }

   public function getPassword() {
       return $this->Password;
   }

   public function setFirstName($FirstName) {
       $this->FirstName = $FirstName;
   }

   public function setLastName($LastName) {
       $this->LastName = $LastName;
   }

   public function setPhoneNumber($PhoneNumber) {
       $this->PhoneNumber = $PhoneNumber;
   }

   public function setEmail($Email) {
       $this->Email = $Email;
   }

   public function setAge($Age) {
       $this->Age = $Age;
   }

   public function setGender($Gender) {
       $this->Gender = $Gender;
   }

   public function setPassword($Password) {
       $this->Password = $Password;
   }

      use mysql{
        mysql::__construct as private __mysqlconstruct;
    }
    
    public function __construct()
    {
        global $config;
        
       $this->__mysqlconstruct($config);
    }
    //login
    public function Login($email,$password)
    {
       $table='UsersInformation';
       $fields='ID,FirstName,LastName,UserTypeNumber,FirstLogin,Password';
       $result= $this->select($table,"Email='$email'",$fields);
       if($this->countRows()==0){
            return false;
       } else {
           
            $userTypeNumber;
            $Row= mysqli_fetch_assoc($result);
            if(!password_verify($password,$Row['Password']))
            {
                return false;
            }
            
            $_SESSION['id']=$Row['ID'];
            $_SESSION['FirstName']=$Row['FirstName'];
            $_SESSION['LastName']=$Row['LastName'];
            $_SESSION['FirstLogin']=$Row['FirstLogin'];
            $userTypeNumber=$Row['UserTypeNumber'];
            $table1='UsersType';
            $field='UserType';
            $Result= $this->select($table1,"userTypeNumber=$userTypeNumber",$field);
            $row= mysqli_fetch_assoc($Result);
            $_SESSION['UserType']=$row['UserType'];
            
            return true;   
       }
       
    }
    //set new password for user that is added by admin
    public function NewPassword($ID,$password)
    {
        $table='UsersInformation';
        $hashedPassword= password_hash($password, PASSWORD_DEFAULT);
        $data= array('Password'=>$hashedPassword,'FirstLogin'=>1);
        $this->update($table, $data, "ID=$ID");
    } 
    
    public function EditProfile($PhoneNumber,$Password)
    {
        $table='UsersInformation';
        $id=$_SESSION['id'];
        $hashedPassword= password_hash($Password, PASSWORD_DEFAULT);
        $data= array('Password'=>$hashedPassword,'PhoneNumber'=>$PhoneNumber);
        $this->update($table, $data, "ID='$id'");
    }

    //get phonenumber of user
    public function GetPhone()
    {
        $table='UsersInformation';
        $id=$_SESSION['id'];
        $fields='PhoneNumber';
        $result= $this->select($table,"ID='$id'",$fields);
        return mysqli_fetch_assoc($result);     
    }
   
    //set profile picture
    public function ProfilePicture($documentRoot)
    {
        $upload_directory=$documentRoot.'/ProfilePicture';
        $ProfilePicture='';
        $id=$_SESSION['id'];
        if($_FILES["ProfilePicture"]['error']==UPLOAD_ERR_OK)
        {
         
            $tmpName=$_FILES['ProfilePicture']['tmp_name'];
            //to ignore any special charecters and get the base name only
            $ProfilePicture= basename($_FILES['ProfilePicture']['name']);
            $ProfilePicture=$id.$ProfilePicture;
            //move file from temp directory to another place
            move_uploaded_file($tmpName, "$upload_directory/$ProfilePicture");    
           
           
            $result= $this->select('ProfilePictures',"UserID='$id'");
            if($this->countRows()==1){
                $data= array('ProfilePicture'=>$ProfilePicture);
                $this->update('ProfilePictures', $data, "UserID='$id'");
            } else {
                
                $fields=array('UserID'=>$id,'ProfilePicture'=>$ProfilePicture);
                $table='ProfilePictures';
                $this->insert($table, $fields);
            }
            
        } else 
        {
            echo 'File can not be uploaded';
        }
    }
    //log out
    public function Logout()
    {
        session_destroy();
        
    }
   
}