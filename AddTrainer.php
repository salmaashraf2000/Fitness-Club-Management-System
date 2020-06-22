<?php

    include_once("AdminNavigationBar.html");
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="Styles.css">
        <style>
            body {
               background: url('https://image.freepik.com/free-photo/blur-gym-fitness_74190-4444.jpg')no-repeat center center fixed;
               background-size: cover;
               
              
            }
        </style>

    </head>
    <body>
    <div class="container"> 
             <h1>Add Trainer</h1> 
    </div>     
    <div class="container">    
     <form method="post" action=""> 
         <div class="row">   
         <div class="form-group">      
             <label class="col-sm-2">First Name: </label> 
             <div class="col-sm-4"> 
             <input type="text" name="FirstName" class="form-control" placeholder="enter first name" value="<?php  echo $FirstName;?>" required="true"><?php echo $FirstnameErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">
             <label class="col-sm-2">Last Name: </label> 
             <div class="col-sm-4"> 
             <input type="text" name="LastName" value="<?php echo $LastName;?>" placeholder="enter last name" class="form-control" required="true"><?php echo $LastnameErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group"> 
             <label class="col-sm-2"> E-mail: </label> 
             <div class="col-sm-4"> 
             <input type="email" name="Email" value="<?php echo $Email;?>" placeholder="enter email" class="form-control" required="true"><?php echo $emailErr;?>
             </div>
         </div>
         <br><br>
         
         <div class="form-group">  
             <label class="col-sm-2">Password: </label> 
             <div class="col-sm-4"> 
            <input type="password" name="Password"  placeholder="password length 8 or more"class="form-control" required="true"><?php echo $passwordErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2">Phone Number: </label>
             <div class="col-sm-4"> 
             <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}"placeholder="phone number" class="form-control" required="true"><?php echo $PhoneErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">   
             <label class="col-sm-2">Age: </label> 
             <div class="col-sm-4"> 
             <input type="number" name="Age" min="10" value="<?php echo $Age;?>" placeholder="enter age" class="form-control" required="true"><?php echo $AgeErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2">Gender: </label>
             <div class="col-sm-4"> 
              <input type="radio" name="Gender"  value="female" required="true"><label>Female</label> 
              <br><br>
              <input type="radio" name="Gender" value="male"><label>Male</label> <?php echo $genderErr;?>   
              <br><br>
              
             </div>
         </div>
         <br><br>
        <div class="form-group">  
             <label class="col-sm-2">Shift: </label>
             <div class="col-sm-4"> 
              <input type="radio" name="Shift"  value="morning" required="true"><label>Morning (8:00->14:00)</label> 
              <br><br>
              <input type="radio" name="Shift" value="evening"><label> Evening (14:00->22:00)</label>    <?php echo $ShiftErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2">Package Number: </label>
             <div class="col-sm-4"> 
              <select name="Packages" class="form-control" required="true">
                <option value=""></option>
                <?php foreach ($packages as $row){ ?>
                
                <option  value="<?php echo $row['PackageNumber'];?>" ><?php echo $row['PackageNumber']; ?></option>
                <?php } ?>
                
              </select><?php echo $packageNoErr;?>
             </div>
         </div>
         <br><br>
         </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
  
     </form>
    </div>        
    </body>
</html>



