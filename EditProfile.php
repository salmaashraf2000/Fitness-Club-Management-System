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
        require_once 'Admin.php';
        require_once  'Member.php';
        require_once 'Admin.php';
        require_once 'Validation.php';
        require_once 'Person.php';
        
    


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

             
             echo "<script>alert('Information updated successfully');
             window.location.href='ViewProfileAdmin.php';
              </script>";
         }else if($_SESSION['UserType']=='member')
         {

             
             echo "<script>alert('Information updated successfully');
             window.location.href='ViewProfileMember.php';
              </script>";
         } else if($_SESSION['UserType']=='trainer')
         {


             echo "<script>alert('Information updated successfully');
             window.location.href='ViewProfileTrainer.php';
              </script>";
         }
        
        


      }else
      {

          $msg='Failed to update information';
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
    <body>
    <div class="container"> 
             <h1>Edit Profile</h1> 
    </div>    
    <div class="container">    
     <form method="post" enctype="multipart/form-data">
         <div class="form-group"> 
             <label class="col-sm-2">Password: </label> 
             <div class="col-sm-4"> 
             <input type="password" name="Password"  placeholder="password length 8 or more"class="form-control" required="true"><?php echo $passwordErr;?>    
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2">Phone Number: </label> 
             <div class="col-sm-4"> 
             <input type="tel" id="PhoneNumber" name="PhoneNumber" pattern="[0]{1}[1]{1}[0-9]{9}" class="form-control" required="true" value="<?php echo '0'.$row['PhoneNumber'];?>"><?php echo $PhoneErr;?>             
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2" for="profilepicture">Profile Picture</label>
             <div class="col-sm-4"> 
             <input type="file" name="ProfilePicture"/>
             </div>
         </div>
         <br><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
 
     </form>
    </div>     
    </body>
</html>



