<?php


    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

    require_once 'Admin.php';
    require_once 'Validation.php';

    $FirstName= $Email = $LastName  =" ";
    $FirstnameErr = $emailErr = $genderErr = $LastnameErr = $passwordErr= $AgeErr = $PhoneErr ="";
    $msg=""; 
    $valid=new Validation();

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //remove unwanted characters from data
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
        $genderErr=$valid->Radio($_POST["Gender"]);

        $FirstName=$_POST['FirstName'];
        $LastName=$_POST['LastName'];
        $Email=$_POST['Email'];
        $Age=$_POST['Age'];
        $PhoneNumber=$_POST['PhoneNumber'];

      if($FirstnameErr=="" && $emailErr=="" &&  $genderErr=="" && $LastnameErr=="" && $passwordErr=="" && $AgeErr=="" && $PhoneErr=="")
      {

         $admin=new Admin();
         $admin->setFirstName($_POST['FirstName']);
         $admin->setLastName($_POST['LastName']);
         $admin->setPhoneNumber($_POST['PhoneNumber']);
         $admin->setEmail($_POST['Email']);
         $admin->setAge($_POST['Age']);
         $admin->setGender($_POST['Gender']);
         $admin->setPassword($_POST['Password']);
         $admin->AddAdmin($admin);
         $msg='Admin added Successfully';
      }else
      {

          $msg='Failed to add  Admin';
      }


      echo "<script type='text/javascript'>alert('$msg');</script>";

    }
    }else
    {
        echo "<script>alert('Must login');
             window.location.href='index.php';
              </script>";
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
  Phone Number: <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}"><?php echo $PhoneErr;?>
  <br><br>
  Age: <input type="number" name="Age" value="<?php echo $Age;?>" ><?php echo $AgeErr;?>
  <br><br>
  Gender:
  <input type="radio" name="Gender"  value="female">Female
  <input type="radio" name="Gender" value="male">Male   <?php echo $genderErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
        
    </body>
</html>-->


