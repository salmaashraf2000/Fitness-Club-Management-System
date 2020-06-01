<?php
require_once 'Admin.php';
require_once  'Member.php';
require_once 'Admin.php';
require_once 'Validation.php';
require_once 'Person.php';
session_start();



 $passwordErr=  $PhoneErr ="";
$msg=""; 
$person=new Person();
$row=$person->GetPhone();
 $valid=new Validation();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    
    $_POST['PhoneNumber']= $valid->test_input($_POST['PhoneNumber']);
    
    
    $passwordErr=$valid->Password($_POST['Password']);
    $PhoneErr=$valid->PhoneNumber($_POST['PhoneNumber']);
    
    
    
    $Password=$_POST['Password'];
    
    $PhoneNumber=$_POST['PhoneNumber'];
 
  if( $passwordErr=="" && $PhoneErr=="")
  {
     
     if($_SESSION['UserType']=='admin')
     {
         $admin=new Admin();
         $admin->EditProfile($_POST['PhoneNumber'],$Password);
         $admin->ProfilePicture($_SERVER['DOCUMENT_ROOT']);  
     }else if($_SESSION['UserType']=='member')
     {
         $member=new Member();
         $member->EditProfile($_POST['PhoneNumber'],$Password);
         $member->ProfilePicture($_SERVER['DOCUMENT_ROOT']);  
     } else if($_SESSION['UserType']=='trainer')
     {
         $trainer=new Trainer();
         $trainer->EditProfile($_POST['PhoneNumber'],$Password);
         $trainer->ProfilePicture($_SERVER['DOCUMENT_ROOT']);  
     }
     
     if($_SESSION['UserType']=='admin')
     {
          
         header("Location:ViewProfileAdmin.php");
     }else if($_SESSION['UserType']=='member')
     {
         
         header("Location:ViewProfileMember.php");
     } else if($_SESSION['UserType']=='trainer')
     {
         
         header("Location:ViewProfileTrainer.php");
     }
     
    //$msg='Information updated successfully';
    
  
  }else
  {
      
      $msg='Failed to update information';
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
     <form method="post" enctype="multipart/form-data"> 
  Password: <input type="password" name="Password"  ><?php echo $passwordErr;?>
  <br><br>
  Phone Number: <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}" value="<?php echo '0'.$row['PhoneNumber'];?>"><?php echo $PhoneErr;?>
  <br><br>
  <label for="profilepicture">Profile Picture</label>
  <input type="file" name="ProfilePicture"/>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
        
    </body>
</html>



