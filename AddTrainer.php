<?php


    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

        require_once 'Admin.php';
        require_once 'Trainer.php';
        require_once 'Validation.php';

        $valid=new Validation();
        $FirstName= $Email = $LastName  =$Age=$PackageNo=$PhoneNumber="";
        $msg="";
        $FirstnameErr = $emailErr = $genderErr = $LastnameErr = $passwordErr= $AgeErr = $PhoneErr =$ShiftErr= $packageNoErr="";
         $admin=new Admin();
         
        //get all packages 
        $packages=$admin->ViewPackages();  

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
            $genderErr=$valid->Radio($_POST["Gender"]);
            $ShiftErr=$valid->Number($_POST['Shift']);
            $packageNoErr=$valid->Text($_POST['Packages']);

            $FirstName=$_POST['FirstName'];
            $LastName=$_POST['LastName'];
            $Email=$_POST['Email'];
            $Age=$_POST['Age'];
            $PhoneNumber=$_POST['PhoneNumber'];
            $PackageNo=$_POST['Packages'];
            


          if($FirstnameErr=="" && $emailErr=="" &&  $genderErr=="" && $LastnameErr=="" && $passwordErr=="" && $AgeErr=="" && $PhoneErr=="" && $ShiftErr=="" && $packageNoErr=="")
          {


             $trainer=new Trainer();
             $trainer->setFirstName($_POST['FirstName']);
             $trainer->setLastName($_POST['FirstName']);
             $trainer->setPhoneNumber($_POST['PhoneNumber']);
             $trainer->setEmail($_POST['Email']);
             $trainer->setAge($_POST['Age']);
             $trainer->setGender($_POST['Gender']);
             $trainer->setPassword($_POST['Password']);

             if($_POST['Shift']==='morning')
             {

                 $trainer->setTimeStartingShift(8);
                 $trainer->setTimeEndingShift(14);
             } else 
             {

                 $trainer->setTimeStartingShift(14);
                 $trainer->setTimeEndingShift(22);
             }
             $admin->AddTrainer($trainer,$_POST['Packages']);
               $msg='Trainer added Successfully';
          }else
          {

              $msg='Failed to add trainer';
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
  <input type="radio" name="Shift" value="evening">Evening (14:00->22:00)   <?php echo $ShiftErr;?>
  <br><br>
  Package Number:
                <select name="Packages">
                <option value=""></option>
                <?php foreach ($packages as $row){ ?>
                
                <option  value="<?php echo $row['PackageNumber'];?>" ><?php echo $row['PackageNumber']; ?></option>
                <?php } ?>
                
            </select><?php echo $packageNoErr;?>
  
  <br><br>
  <input type="submit" name="submit" value="Submit" >   
</form>
        
    </body>
</html>



