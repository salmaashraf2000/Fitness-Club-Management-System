
<?php
session_start();
require_once  'Admin.php';

if($_SESSION['id']){
  $admin=new admin();
  
  $row=$admin->ViewProfile($_SESSION['id']);
} 
 if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  
    if(isset($_POST['submit']))
    {
    
      header("Location:EditProfile.php");
    }  
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     <form method="post">
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





