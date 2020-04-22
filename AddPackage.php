<?php

require 'Admin.php';
require 'Trainer.php';
//session_start();

$PackageInfo=$JacuzziNo=$SpaNo=$SteamNo=$SaunaNo=$NumberOfMonths=$Price=$Discount="";
$PackageInfoErr=$JacuzziNoErr=$SpaNoErr=$SteamNoErr=$SaunaNoErr=$NumberOfMonthsErr=$PriceErr=$DiscountErr=""; 
$msg="";
function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
  
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $_POST['PackageInfo']=test_input($_POST['PackageInfo']);
    $_POST['JacuzziNo']= test_input($_POST['JacuzziNo']);
    $_POST['SpaNo']= test_input($_POST['SpaNo']);
    $_POST['SteamNo']= test_input($_POST['SteamNo']);
    $_POST['SaunaNo']= test_input($_POST['SaunaNo']);
    $_POST['NumberOfMonths']= test_input($_POST['NumberOfMonths']);
    $_POST['Price']= test_input($_POST['Price']);
    $_POST['Discount']= test_input($_POST['Discount']);
   
  if (! (isset($_POST['PackageInfo']) && !empty($_POST["PackageInfo"]))) 
  {
    
    $PackageInfoErr='*This field is required';
  } 
   if (! (isset($_POST['JacuzziNo']) && !empty($_POST['JacuzziNo'])) && $_POST['JacuzziNo']!=='0')
   {
   
    $JacuzziNoErr='*This field is required';
  } 
  
  if (! (isset($_POST['SpaNo']) && !empty($_POST['SpaNo'])) && $_POST['SpaNo']!=='0') 
  {

    $SpaNoErr='*This field is required';
  } 
    
  if (! (isset($_POST['SteamNo']) && !empty($_POST['SteamNo'])) && $_POST['SteamNo']!=='0') 
  {
    
    $SteamNoErr='*This field is required';
  }
  
   if (! (isset($_POST['SaunaNo']) && !empty($_POST['SaunaNo'])) && $_POST['SaunaNo']!=='0') 
  {
    
    $SaunaNoErr='*This field is required';
  }
  
   if (! (isset($_POST['NumberOfMonths']) && !empty($_POST['NumberOfMonths']))) 
  {
    
    $NumberOfMonthsErr='*This field is required';
  }
  
  if (! (isset($_POST['Price']) && !empty($_POST['Price']))) 
  {
    
    $PriceErr='*This field is required';
  }
  
  if (! (isset($_POST['Discount']) && !empty($_POST['Discount'])) && $_POST['Discount']!=='0') 
  {
   
    $DiscountErr='*This field is required';
  }
  
  
  
  if($PackageInfoErr=="" && $JacuzziNoErr=="" &&  $SpaNoErr=="" && $SteamNoErr=="" && $SaunaNoErr=="" && $NumberOfMonthsErr=="" && $PriceErr=="" && $DiscountErr=="" )
  {
     
     $admin=new Admin();
     $package=new Package();
     $package->PackageInfo=$_POST['PackageInfo'];
     $package->JacuzziNo=$_POST['JacuzziNo'];
     $package->SpaNo=$_POST['SpaNo'];
     $package->SteamNo=$_POST['SteamNo'];
     $package->SaunaNo=$_POST['SaunaNo'];
     $package->NumberOfMonths=$_POST['NumberOfMonths'];
     $package->Price=$_POST['Price'];
     $package->Discount=$_POST['Discount'];
     $admin->AddPackage($package);
       $msg='Package added Successfully';
  }else
  {
      
      $msg='Failed to add a Package';
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
  Package Information: 
  <br><br>
  <textarea name="PackageInfo" rows="5" cols="40" value="<?php  echo $PackageInfo;?>"></textarea><?php echo $PackageInfoErr;?>
  <br><br>
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>







