<?php

require_once 'Admin.php';
require_once 'Trainer.php';
require_once 'Validation.php';

//session_start();

$valid=new Validation();
$FirstName= $Email = $LastName  =$Age=$PackageNo=$PhoneNumber="";
$msg="";
$FirstnameErr = $emailErr = $genderErr = $LastnameErr = $passwordErr= $AgeErr = $PhoneErr =$ShiftErr= $packageNoErr="";
 

  
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $_POST['FirstName']=$valid->test_input($_POST['FirstName']);
    $_POST['LastName']= $valid->test_input($_POST['LastName']);
    $_POST['Email']= $valid->test_input($_POST['Email']);
    $_POST['PhoneNumber']= $valid->test_input($_POST['PhoneNumber']);
    
    $FirstnameErr=$valid->Name($_POST['FirstName']);
    $LastnameErr=$valid->Name($_POST['LastName']);
    $emailErr=$valid->Email($_POST['Email']);
    $passwordErr=$valid->Password($_POST['Password']);
    $PhoneErr=$valid->PhoneNumber($_POST['PhoneNumber']);
    $AgeErr=$valid->Age($_POST['Age']);
    $genderErr=$valid->Gender($_POST["Gender"]);
    $ShiftErr=$valid->Number($_POST['Shift']);
    $packageNoErr=$valid->Number($_POST['packageNo']);
    
    $FirstName=$_POST['FirstName'];
    $LastName=$_POST['LastName'];
    $Email=$_POST['Email'];
    $Age=$_POST['Age'];
    $PhoneNumber=$_POST['PhoneNumber'];
    $PackageNo=$_POST['packageNo'];
   /* $_POST['FirstName']=test_input($_POST['FirstName']);
    $_POST['LastName']= test_input($_POST['LastName']);
    $_POST['Email']= test_input($_POST['Email']);
    $_POST['PhoneNumber']= test_input($_POST['PhoneNumber']);
   
  if (! (isset($_POST['FirstName']) && !empty($_POST["FirstName"]))) 
  {
    
    $FirstnameErr='*First name is required';
  } else 
  {
    
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['FirstName']))
    {
      $FirstName=$_POST['FirstName'];
      $FirstnameErr='*First name must contain letters only';
    }
  }
   if (! (isset($_POST['LastName']) && !empty($_POST['LastName'])))
   {
   
    $LastnameErr='*Last name is required';
  } else 
  {
    
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$_POST['LastName'])) 
    {
      $LastName=$_POST['LastName'];
      $LastnameErr='*Last name must contain letters only';
    }
  }
  
  if (! isset($_POST['Email'])) 
  {

    $emailErr='*Email is required';
  } else if(!filter_input(INPUT_POST,'Email',FILTER_VALIDATE_EMAIL))
  {
      $Email=$_POST['Email'];
      $emailErr='*Email not valid';
  }else if($admin->CheckIfEmailExists($_POST['Email'])==true)
  {
      $emailErr='*Email already exists';
  }
    
  if (! (isset($_POST['Password']) && strlen($_POST['Password'])>7)) 
  {
    
    $passwordErr='*Password must be 8 charecters or more';
  }
  
   if (! (isset($_POST['PhoneNumber']) && !empty($_POST['PhoneNumber']))) 
  {
    
    $PhoneErr='*Phone Number is required';
  }else if(strlen ($_POST['PhoneNumber'])!=11)
  {
      $PhoneErr='*Phone Number must be 11 digits';
  }
  
   if (! (isset($_POST['Age']) && !empty($_POST['Age']))) 
  {
    
    $AgeErr='*Age is required field';
  }else if($_POST['Age']<10)
  {
    $error_fields []= 'Age';
    $AgeErr='*Age must be 10 or more';
  }
  

  if (empty($_POST['Gender'])) 
  {
    $genderErr='*Gender is required field';
  } */
  
  /*if (empty($_POST['Shift'])) 
  {
    $ShiftErr='*Shift is required field';
  } 
  if (! (isset($_POST['packageNo']) && !empty($_POST['packageNo']))) 
  {
    
    $packageNoErr='*Package Number is required field';
  }*/
  
   $admin=new Admin();
  if($packageNoErr=="" && ($admin->CheckIfPackageExist($_POST['packageNo']))!==1){
      $packageNoErr='*Package Number does not exist';
  }
  
  if($FirstnameErr=="" && $emailErr=="" &&  $genderErr=="" && $LastnameErr=="" && $passwordErr=="" && $AgeErr=="" && $PhoneErr=="" && $ShiftErr=="" && $packageNoErr=="")
  {
     
     $password= password_hash($_POST['Password'], PASSWORD_DEFAULT);
     $trainer=new Trainer();
     $trainer->setFirstName($_POST['FirstName']);
     $trainer->setLastName($_POST['FirstName']);
     $trainer->setPhoneNumber($_POST['PhoneNumber']);
     $trainer->setEmail($_POST['Email']);
     $trainer->setAge($_POST['Age']);
     $trainer->setGender($_POST['Gender']);
     $trainer->setPassword($password);
     
     if($_POST['Shift']==='morning')
     {
         $startShift=8;
         $endShift=14;

     } else 
     {
         $startShift=14;
         $endShift=22;
         
     }
     $admin->AddTrainer($trainer,$_POST['packageNo'],$startShift,$endShift);
       $msg='Trainer added Successfully';
  }else
  {
      
      $msg='Failed to add trainer';
  }
  
 
  echo "<script type='text/javascript'>alert('$msg');</script>";

}

?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     <form method="post" action="">  
         First Name: <input type="text" name="FirstName" value="<?php  echo $FirstName;?>"><?php echo $FirstnameErr;?>
  <br><br>
   Last Name: <input type="text" name="LastName" value="<?php echo $LastName;?>"><?php echo $LastnameErr;?>
  <br><br>
  E-mail: <input type="email" name="Email" value="<?php echo $Email;?>"><?php echo $emailErr;?>
  <br><br>
  Password: <input type="password" name="Password"  ><?php echo $passwordErr;?>
  <br><br>
  Phone Number: <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}" value="<?php echo $PhoneNumber;?>"><?php echo $PhoneErr;?>
  <br><br>
  Age: <input type="number" name="Age" value="<?php echo $Age;?>" ><?php echo $AgeErr;?>
  <br><br>
  Gender:
  <input type="radio" name="Gender"  value="female">Female
  <input type="radio" name="Gender" value="male">Male   <?php echo $genderErr;?>
  <br><br>
  Shift:
  <input type="radio" name="Shift"  value="morning">Morning (8:00->14:00)
  <input type="radio" name="Shift" value="evening">Evening (14:00->20:00)   <?php echo $ShiftErr;?>
  <br><br>
  Package Number: <input type="number" name="packageNo" min="1" value="<?php echo $PackageNo;?>"><?php echo $packageNoErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>



