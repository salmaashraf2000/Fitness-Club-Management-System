<?php

session_start();
require_once 'Validation.php';
require_once  'Person.php';
 $Email ="";
 $emailErr =  $passwordErr= "";
$valid=new Validation();
$person=new Person();
  
echo 'lo'.$_SESSION['FirstLogin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $_POST['Email']= $valid->test_input($_POST['Email']);
    
    $emailErr=$valid->EmailLogin($_POST['Email']);
    $passwordErr=$valid->Password($_POST['Password']);
    
    $Email=$_POST['Email'];
    if($person->Login($_POST['Email'],$_POST['Password'])==true)
    {        
        if($_SESSION['FirstLogin']==0)
        {
            
            header("Location:NewPassword.php"); 
        }else
        {
             if($_SESSION['UserType']=='admin') //admin
             {
                 header("Location:ViewProfileAdmin.php");
                 
             }else if($_SESSION['UserType']=='member') //member
             {
                 header("Location:ViewProfileMember.php"); 
             
             } else if($_SESSION['UserType']=='trainer')//trainer
             {
                 header("Location:ViewProfileTrainer.php");
            
             }
        }
    }else
    {
        echo '*Wrong Email or password';
    }
   /* if (! isset($_POST['Email'])) 
  {

    $emailErr='*Email is required';
  } else if(!filter_input(INPUT_POST,'Email',FILTER_VALIDATE_EMAIL))
  {
      $Email=$_POST['Email'];
      $emailErr='*Email not valid';
  }
    
  if (! (isset($_POST['Password']))) 
  {
    
    $passwordErr='*Password must be 8 charecters or more';
  }*/
}
   
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       
         <form method="post" action="">  
          E-mail: <input type="email" name="Email" value="<?php echo $Email;?>"><?php echo $emailErr;?>
          <br><br>
          Password: <input type="password" name="Password"  ><?php echo $passwordErr;?>
          <br><br>
          <input type="submit" name="submit1" value="Login" > OR  <a href="SignUp.php"> Sign up </a>
        </form>
    </body>
</html>




