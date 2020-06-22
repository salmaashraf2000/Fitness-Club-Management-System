<?php

    include_once("AdminNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

    require_once 'Admin.php';
    require_once 'Trainer.php';
    require_once 'Validation.php';
    //session_start();

    $PackageInfoErr=$JacuzziNoErr=$SpaNoErr=$SteamNoErr=$SaunaNoErr=$NumberOfMonthsErr=$PriceErr=$DiscountErr=""; 
    $msg="";
    $PackageNumber= filter_input(INPUT_GET,'PackageNumber',FILTER_SANITIZE_NUMBER_INT);
    $PackageInfo= filter_input(INPUT_GET,'PackageInfo',FILTER_SANITIZE_STRING);
    $JacuzziNo= filter_input(INPUT_GET,'JacuzziNo',FILTER_SANITIZE_NUMBER_INT);
    $SpaNo= filter_input(INPUT_GET,'SpaNo',FILTER_SANITIZE_NUMBER_INT);
    $SteamNo= filter_input(INPUT_GET,'SteamNo',FILTER_SANITIZE_NUMBER_INT);
    $SaunaNo= filter_input(INPUT_GET,'SaunaNo',FILTER_SANITIZE_NUMBER_INT);
    $NumberOfMonths= filter_input(INPUT_GET,'NumberOfMonths',FILTER_SANITIZE_NUMBER_INT);
    $Price= filter_input(INPUT_GET,'Price',FILTER_SANITIZE_NUMBER_INT);
    $Discount= filter_input(INPUT_GET,'Discount',FILTER_SANITIZE_NUMBER_INT);

    $admin=new Admin();

    $valid=new Validation();  
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $_POST['PackageInfo']=$valid->test_input($_POST['PackageInfo']);
        $_POST['JacuzziNo']= $valid->test_input($_POST['JacuzziNo']);
        $_POST['SpaNo']= $valid->test_input($_POST['SpaNo']);
        $_POST['SteamNo']= $valid->test_input($_POST['SteamNo']);
        $_POST['SaunaNo']= $valid->test_input($_POST['SaunaNo']);
        $_POST['NumberOfMonths']= $valid->test_input($_POST['NumberOfMonths']);
        $_POST['Price']= $valid->test_input($_POST['Price']);
        $_POST['Discount']= $valid->test_input($_POST['Discount']);

        $PackageInfoErr=$valid->Text($_POST["PackageInfo"]);
        $JacuzziNoErr=$valid->Number($_POST['JacuzziNo']);
        $SpaNoErr=$valid->Number($_POST['SpaNo']);
        $SteamNoErr=$valid->Number($_POST['SteamNo']);
        $SaunaNoErr=$valid->Number($_POST['SaunaNo']);
        $NumberOfMonthsErr=$valid->Number($_POST['NumberOfMonths']);
        $PriceErr=$valid->Number($_POST['Price']);  
        $DiscountErr=$valid->Number($_POST['Discount']);






      if($PackageInfoErr=="" && $JacuzziNoErr=="" &&  $SpaNoErr=="" && $SteamNoErr=="" && $SaunaNoErr=="" && $NumberOfMonthsErr=="" && $PriceErr=="" && $DiscountErr=="" )
      {


         $package=new Package();
         $package->setPackageInfo($_POST['PackageInfo']);
         $package->setJacuzziNo($_POST['JacuzziNo']);
         $package->setSpaNo($_POST['SpaNo']);
         $package->setSteamNo($_POST['SteamNo']);
         $package->setSaunaNo($_POST['SaunaNo']);
         $package->setNumberOfMonths($_POST['NumberOfMonths']);
         $package->setPrice($_POST['Price']);
         $package->setDiscount($_POST['Discount']);
         $admin->EditPackage($package,$PackageNumber);
        
         echo "<script>alert('Package updated Successfully');
             window.location.href='ViewPackages.php';
              </script>";
        
      }else
      {

          $msg='Failed to update the Package all fields must be filled';
          echo "<script type='text/javascript'>alert('$msg');</script>";
      }


     

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
             <h1>Edit Package</h1> 
    </div>    
    <div class="container">     
     <form method="post" action="">  
  
            <div class="form-group">      
                     <label class="col-sm-2">Price: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="Price" min="0" class="form-control" placeholder="enter package price" required="true" value="<?php echo $Price;?>"><?php echo $PriceErr;?>
                     </div>
                 </div>
            <br><br>
            <div class="form-group">
                     <label class="col-sm-2">Discount: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="Discount" min="0" value="<?php echo $Discount;?>" required="true" placeholder="enter discount" class="form-control"><?php echo $DiscountErr;?>
                     </div>
            </div>
             <br><br>
            <div class="form-group">
                     <label class="col-sm-2">Number of sessions of Jacuzzi: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="JacuzziNo" min="0" placeholder="enter number of sessions" required="true" class="form-control" value="<?php echo $JacuzziNo;?>"><?php echo $JacuzziNoErr;?>            
                     </div>
            </div>
            <br><br>
             <div class="form-group">
                     <label class="col-sm-2">Number of sessions of Spa:  </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="SpaNo" min="0" placeholder="enter number of sessions" required="true" class="form-control" value="<?php echo $SpaNo;?>"><?php echo $SpaNoErr;?>
                     </div>
            </div>
            <br><br>
            <div class="form-group">
                     <label class="col-sm-2"> Number of sessions of Steam: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="SteamNo" min="0" placeholder="enter number of sessions" required="true" class="form-control" value="<?php echo $SteamNo;?>"><?php echo $SteamNoErr;?>
                     </div>
            </div>
            <br><br>
            <div class="form-group">
                     <label class="col-sm-2">Number of sessions of Sauna: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="SaunaNo" min="0" placeholder="enter number of sessions" required="true" class="form-control" value="<?php echo $SaunaNo;?>"><?php echo $SaunaNoErr;?>             </div>
            </div>
            <br><br>
            <div class="form-group">
                     <label class="col-sm-2">Package's Number of Months: </label> 
                     <div class="col-sm-4"> 
                     <input type="number" name="NumberOfMonths" min="1" placeholder="enter number of months of package" required="true" class="form-control" value="<?php echo $NumberOfMonths;?>"><?php echo $NumberOfMonthsErr;?>             </div>
            </div>
            <br><br>
            <div class="form-group">
                     <label class="col-sm-2">Package Description: </label> 
                     <div class="col-sm-4"> 
                     <textarea name="PackageInfo" rows="5" cols="40" placeholder="describe the package" required="true" class="form-control"><?php  echo $PackageInfo;?></textarea><?php echo $PackageInfoErr;?>
                     </div>
            </div>
            <br><br>
             <input type="submit" class="btn btn-primary" name="submit" value="Submit">      

    </form>
    </div>   
    </body>
</html>







