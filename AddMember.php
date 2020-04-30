<?php
require_once 'Admin.php';
require_once  'Member.php';
require_once 'Validation.php';
//session_start();


$FirstName= $Email = $LastName =$Age=$PhoneNumber ="";
$FirstnameErr = $emailErr = $genderErr = $LastnameErr = $passwordErr= $AgeErr = $PhoneErr ="";
$msg=""; 

/*function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }*/
 $valid=new Validation();
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
    
    $FirstName=$_POST['FirstName'];
    $LastName=$_POST['LastName'];
    $Email=$_POST['Email'];
    $Age=$_POST['Age'];
    $PhoneNumber=$_POST['PhoneNumber'];
 /* if (! (isset($_POST['FirstName']) && !empty($_POST["FirstName"]))) 
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
  }*/
   /*if (! (isset($_POST['LastName']) && !empty($_POST['LastName'])))
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
  }*/
  
  /*if (! isset($_POST['Email'])) 
  {

    $emailErr='*Email is required';
  } else if(!filter_input(INPUT_POST,'Email',FILTER_VALIDATE_EMAIL))
  {
      $Email=$_POST['Email'];
      $emailErr='*Email not valid';
  }else if($admin->CheckIfEmailExists($_POST['Email'])==true)
  {
      $emailErr='*Email already exists';
  }*/
    
  /*if (! (isset($_POST['Password']) && strlen($_POST['Password'])>7)) 
  {
    
    $passwordErr='*Password must be 8 charecters or more';
  }*/
  
   /*if (! (isset($_POST['PhoneNumber']) && !empty($_POST['PhoneNumber']))) 
  {
    
    $PhoneErr='*Phone Number is required';
  }else if(strlen ($_POST['PhoneNumber'])!=11)
  {
      $PhoneErr='*Phone Number must be 11 digits';
  }*/
  
   /*if (! (isset($_POST['Age']) && !empty($_POST['Age']))) 
  {
    
    $AgeErr='*Age is required field';
  }else if($_POST['Age']<10)
  {
    $error_fields []= 'Age';
    $AgeErr='*Age must be 10 or more';
  }*/
  

  /*if (empty($_POST["Gender"])) 
  {
    $genderErr='*Gender is required field';
  } */
  
  if($FirstnameErr=="" && $emailErr=="" &&  $genderErr=="" && $LastnameErr=="" && $passwordErr=="" && $AgeErr=="" && $PhoneErr=="")
  {
     $password= password_hash($_POST['Password'], PASSWORD_DEFAULT);
     $admin=new Admin();
     $member=new Member();
     $member->setFirstName($_POST['FirstName']);
     $member->setLastName($_POST['FirstName']);
     $member->setPhoneNumber($_POST['PhoneNumber']);
     $member->setEmail($_POST['Email']);
     $member->setAge($_POST['Age']);
     $member->setGender($_POST['Gender']);
     $member->setPassword($password);
     $admin->AddMember($member);
    $msg='Member added Successfully';
  
  }else
  {
      
      $msg='Failed to add a Member';
  }
  
 
  echo "<script type='text/javascript'>alert('$msg');</script>";
  
}
?>
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
  Age: <input type="number" name="Age" min="10" value="<?php echo $Age;?>" ><?php echo $AgeErr;?>
  <br><br>
  Gender:
  <input type="radio" name="Gender"  value="female">Female
  <input type="radio" name="Gender" value="male">Male   <?php echo $genderErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
        
    </body>
</html>


