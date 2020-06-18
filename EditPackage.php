<?php


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
    </head>
    <body>
     <form method="post" action="">  
    Price: <input type="number" name="Price" min="0" value="<?php echo $Price;?>"><?php echo $PriceErr;?>
  <br><br>
  Discount: <input type="number" name="Discount" min="0" value="<?php echo $Discount;?>"><?php echo $DiscountErr;?>
  <br><br>     
  Number of sessions of Jacuzzi: <input type="number" name="JacuzziNo" min="0" value="<?php echo $JacuzziNo;?>"><?php echo $JacuzziNoErr;?>
  <br><br>
  Number of sessions of Spa: <input type="number" name="SpaNo" min="0" value="<?php echo $SpaNo;?>"><?php echo $SpaNoErr;?>
  <br><br>
  Number of sessions of Steam: <input type="number" name="SteamNo" min="0" value="<?php echo $SteamNo;?>"><?php echo $SteamNoErr;?>
  <br><br>
  Number of sessions of Sauna: <input type="number" name="SaunaNo" min="0" value="<?php echo $SaunaNo;?>"><?php echo $SaunaNoErr;?>
  <br><br>
  Package Number of Months: <input type="number" name="NumberOfMonths" min="1" value="<?php echo $NumberOfMonths;?>"><?php echo $NumberOfMonthsErr;?>
  <br><br>
  Package Description: 
  <br><br>
  <textarea name="PackageInfo" rows="5" cols="40" ><?php  echo $PackageInfo;?></textarea><?php echo $PackageInfoErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>-->







