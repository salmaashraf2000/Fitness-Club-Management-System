<?php

session_start();
require_once 'Validation.php';
require_once  'Person.php';
 $Email ="";
 $emailErr =  $passwordErr= "";
$valid=new Validation();
$person=new Person();
  

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
   
}
   
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

body {
   background: url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/home-gym-lead-image-1586968939.jpg?crop=1.00xw:0.461xh;0.00160xw,0.297xh&resize=1200:*')no-repeat center center fixed;
    background-size: cover;
}



.container .content {
  position: absolute;
  bottom: 0;
  background: rgb(0, 0, 0); /* Fallback color */
  background: rgba(0, 0, 0, 0.5); /* Black background with 0.5 opacity */
  color: #f1f1f1;
  width: 100%;
  padding: 20px;
}
</style>
</head>
<body>
        <title></title>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="Styles.css">
    </head>
    <body>
      
    <div class="container">   
        <div class="content">  
            <h1>Welcome To Our Fitness Club</h1>
                <form method="post" action="">  
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
                  <input type="submit" name="submit1" value="Login" class="btn btn-primary"> OR  <a href="SignUp.php" class="btn btn-primary"> Sign up </a>
                </form>
        </div>    
    </div>    
    </body>
</html>




