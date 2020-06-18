<?php
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
    </head>
    <body>
        <form method="post" >
          <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo 'No Image';} ?> 
        <br><br>    
        <label for="Profile_Picture">Profile Picture</label> 
        <label for="name">Name : </label><?php echo $row['FirstName'].' '.$row['LastName']; ?>
        <br><br>
        <label for="Email">Email : </label><?php echo $row['Email']; ?>
        <br><br>
        <label for="PhoneNumber">Phone Number :   </label><?php echo '0'.$row['PhoneNumber']; ?>
        <br><br>
       
       <input type="submit" name="submit" value="Edit Profile">  
     </form>
        
    </body>
</html>





