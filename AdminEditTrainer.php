<?php

require_once 'Admin.php';
require_once 'Validation.php';
//session_start();

$packageNo="";
$packageNoErr=$ShiftErr=""; 
$msg="";
$ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$packageNo=filter_input(INPUT_GET,'packageNo',FILTER_SANITIZE_NUMBER_INT);
$TimeStartingShift=filter_input(INPUT_GET,'TimeStartingShift',FILTER_SANITIZE_NUMBER_INT);
$TimeEndingShift=filter_input(INPUT_GET,'TimeEndingShift',FILTER_SANITIZE_NUMBER_INT);
$admin=new Admin();
$valid=new Validation();
//$trainer=$admin->GetTrainerInfo($ID);
$packages=$admin->ViewPackages();  

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
 
   $packageNoErr=$valid->Text($_POST['Packages']);
   $ShiftErr=$valid->Text($_POST['Shift']);
  
  if($packageNoErr=="" && $ShiftErr=="" )
  {
     
       if($admin->CheckIfAnyMemberEnrollWithTrainer($ID)==false || ($packageNo==$_POST['Packages'] && (($TimeStartingShift==8 && $_POST[Shift]=='morning') || ($TimeStartingShift==14 && $_POST[Shift]=='evening'))  ))
       {
            $admin->EditTrainer($ID,$_POST['Shift'], $_POST['Packages']);
            header("Location:ViewTrainers.php");
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

?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     <form method="post">  
    Packages : <select name="Packages">
                <option value=""></option>
                <?php foreach ($packages as $row){ ?>
                
                <option  value="<?php echo $row['PackageNumber']; ?>" <?php if($packageNo==$row['PackageNumber']){ echo"selected";} ?> ><?php echo $row['PackageNumber']; ?></option>
                <?php } ?>
                
            </select><?php echo $packageNoErr;?>
  <br><br>
  Shift:
  <input type="radio" name="Shift"  value="morning"  <?php if($TimeStartingShift==8){ echo"checked";} ?>>Morning (8:00->14:00)
  <input type="radio" name="Shift" value="evening"  <?php if($TimeStartingShift==14){ echo"checked";} ?>>Evening (14:00->22:00) 
  <br><br><?php echo $ShiftErr;?>
  
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>








