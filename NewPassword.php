
<?php

    session_start();
    if($_SESSION['UserType']=='admin')
     { 
         include_once("AdminNavigationBar.html");
     }else if($_SESSION['UserType']=='member')
     {
         include_once("MemberNavigationBar.html");
     } else if($_SESSION['UserType']=='trainer')
     {
          include_once("TrainerNavigationBar.html");
     }
    if($_SESSION['id'])
    {

        require_once 'Validation.php';
        require_once  'Person.php';
        $passwordErr= "";
        $valid=new Validation();
        $person=new Person();  

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $passwordErr=$valid->Password($_POST['Password']);
            if($passwordErr=="")
            {

                $person->NewPassword($_SESSION['id'], $_POST['Password']);
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
             <h1>New Password</h1> 
    </div>     
     <div class="container">     
     <form method="post" action="">  
             <h1>Please enter your new password  </h1> 
        <div class="form-group">  
             <label class="col-sm-2">Password: </label> 
             <div class="col-sm-4"> 
              <input type="password" name="Password" placeholder="password length 8 or more"class="form-control" required="true"><?php echo $passwordErr;?>             
             </div>
         </div>
          <br><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  

     </form>
    </div>    
    </body>
</html>




