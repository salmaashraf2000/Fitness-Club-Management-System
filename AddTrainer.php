<?php

require 'Admin.php';
require 'Trainer.php';
//session_start();

$error_fields=array();
$FirstName= $Email = $LastName  =" ";
$msg="";
$FirstnameErr = $emailErr = $genderErr = $LastnameErr = $passwordErr= $AgeErr = $PhoneErr =$ShiftErr= $packageNoErr="";
 
function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
  
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $_POST['FirstName']=test_input($_POST['FirstName']);
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
  } 
  
  if (empty($_POST['Shift'])) 
  {
    $ShiftErr='*Shift is required field';
  } 
  if (! (isset($_POST['packageNo']) && !empty($_POST['packageNo']))) 
  {
    
    $packageNoErr='*Package Number is required field';
  }
  
   $admin=new Admin();
  if($packageNoErr=="" && ($admin->CheckIfPackageExist($_POST['packageNo']))!==1){
      $packageNoErr='*Package Number does not exist';
  }
  
  if($FirstnameErr=="" && $emailErr=="" &&  $genderErr=="" && $LastnameErr=="" && $passwordErr=="" && $AgeErr=="" && $PhoneErr=="" && $ShiftErr=="" && $packageNoErr=="")
  {
     
     
     $trainer=new Trainer();
     $trainer->FirstName=$_POST['FirstName'];
     $trainer->LastName=$_POST['LastName'];
     $trainer->PhoneNumber=$_POST['PhoneNumber'];
     $trainer->Email=$_POST['Email'];
     $trainer->Age=$_POST['Age'];
     $trainer->Gender=$_POST['Gender'];
     $trainer->Password=$_POST['Password'];
     
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
  Phone Number: <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}"><?php echo $PhoneErr;?>
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
  Package Number: <input type="number" name="packageNo" ><?php echo $packageNoErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>



