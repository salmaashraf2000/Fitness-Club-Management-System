<?php

    include_once("AdminNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

        require_once 'Admin.php';
        require_once 'Validation.php';

        $packageNo="";
        $packageNoErr=$ShiftErr=""; 
        $msg="";
        $ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $packageNo=filter_input(INPUT_GET,'packageNo',FILTER_SANITIZE_NUMBER_INT);
        $TimeStartingShift=filter_input(INPUT_GET,'TimeStartingShift',FILTER_SANITIZE_NUMBER_INT);
        $TimeEndingShift=filter_input(INPUT_GET,'TimeEndingShift',FILTER_SANITIZE_NUMBER_INT);
        $admin=new Admin();
        $valid=new Validation();

        //get all packages
        $packages=$admin->ViewPackages();  

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

           $packageNoErr=$valid->Text($_POST['Packages']);
           $ShiftErr=$valid->Text($_POST['Shift']);

          if($packageNoErr=="" && $ShiftErr=="" )
          {

               if($admin->CheckIfAnyMemberEnrollWithTrainer($ID)==false || ($packageNo==$_POST['Packages'] && (($TimeStartingShift==8 && $_POST[Shift]=='morning') || ($TimeStartingShift==14 && $_POST[Shift]=='evening'))  ))
               {
                   //edit trainer's data
                    $admin->EditTrainer($ID,$_POST['Shift'], $_POST['Packages']);
                    echo "<script>alert('Information updated successfully');
                    window.location.href='ViewTrainers.php';
                    </script>";
               } else 
               {
                      //some members are training with this trainer ,if you change shift or package the members wont have a trainer
                      $msg='Can not update information as there would be a conflict';

               }
               //$msg='Information updated successfully';

          }else
          {

              $msg='Failed to update information';

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
         <h1>Edit Trainer Shift/Package working in</h1> 
    </div>    
    <div class="container">     
     <form method="post">  
    
        <div class="form-group">  
             <label class="col-sm-2">Packages : </label>
             <div class="col-sm-4"> 
                <select name="Packages" class="form-control" required="true">
                <option value=""></option>
                <?php foreach ($packages as $row){ ?>
                
                <option  value="<?php echo $row['PackageNumber']; ?>" <?php if($packageNo==$row['PackageNumber']){ echo"selected";} ?> ><?php echo $row['PackageNumber']; ?></option>
                <?php } ?>
                
                </select><?php echo $packageNoErr;?>
             </div>
         </div>
        <br><br>
        <div class="form-check">  
            <label class="col-sm-2">Shift: </label>
            <div class="col-sm-4"> 
            <input type="radio" name="Shift"  value="morning"  <?php if($TimeStartingShift==8){ echo"checked";} ?>>Morning (8:00->14:00)
            <input type="radio" name="Shift" value="evening"  <?php if($TimeStartingShift==14){ echo"checked";} ?>>Evening (14:00->22:00) 
            <br><br><?php echo $ShiftErr;?>
            </div>
         </div>
         <br><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">    
    </form>
   </div>      
    </body>
</html>








