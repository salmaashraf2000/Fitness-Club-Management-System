
<?php
session_start();
require_once  'Trainer.php';
if($_SESSION['id']){
  $trainer=new Trainer();
  echo $_SESSION['id'];
  $row=$trainer->ViewProfile($_SESSION['id']);
} 
 if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
      header("Location:EditProfile.php");
      
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
        <label for="PackageNumber">Package Number Working in :   </label><?php echo $row['packageNo']; ?>
        <br><br>
        <label for="SessionTime">Session Time :   </label><?php echo 'From '.$row['TimeStartingShift'].':00 To '.$row['TimeEndingShift'].':00'; ?> 
        <br><br>
        
       <input type="submit" name="submit" value="Edit Profile">  
     </form>
        
    </body>
</html>





