
<?php

    session_start();

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
    </head>
    <body>
       
         <form method="post" action="">  
             <h1>Please enter your new password  </h1> 
          <br><br>
          Password: <input type="password" name="Password"  ><?php echo $passwordErr;?>
          <br><br>
          <input type="submit" name="submit1" value="Submit" > 
        </form>
    </body>
</html>




