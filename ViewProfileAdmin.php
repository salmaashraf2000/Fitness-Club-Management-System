<?php

     include_once("AdminNavigationBar.html");
    session_start();

    //check if a member is loggedin
    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {
        require_once  'Admin.php';

        $admin=new admin();

        //get data of the admin
         $row=$admin->ViewProfile($_SESSION['id']);
        
         //if the admin clicked edit profile button 
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            if(isset($_POST['submit']))
            {

              header("Location:EditProfile.php");
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
             <h1>My Profile</h1> 
        </div>    
        <div class="container"> 
        <form method="post" class="form-horizontal">
           <div class="row"> 
             <div class="form-group"> 

                 <div class="col-sm-4"> 
                  <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo '<img  src="https://www-nomadcruise-com.exactdn.com/wp-content/uploads/22-223930_avatar-person-neutral-man-blank-face-buddy-facebook.png" style="width: 150px; height:150px""> ';}  ?> 
                   <br><br>                
                 </div>
             </div>
             <br><br>
             <div class="form-group">  
                 <label class="col-sm-2"for="name">Name: </label> 

                 <label class="col-sm-2"> <?php echo $row['FirstName'].' '.$row['LastName']; ?> </label>
             </div>
             <br><br>
             <div class="form-group">  
                 <label class="col-sm-2"for="Email">Email : </label>
                 <div class="col-sm-4"> 
                 <label class="col-sm-2"> <?php echo $row['Email']; ?></label>
                 </div>
             </div>
            <br><br>
            <div class="form-group">  
                 <label class="col-sm-2" for="PhoneNumber">Phone Number: </label>
                 <label class="col-sm-2" ><?php echo '0'.$row['PhoneNumber']; ?></label>
             </div>
             <br><br>
           </div>
           <input type="submit" class="btn btn-primary" name="submit" value="Edit Profile">  

       </form>
     </div>   
    </body>
</html>





