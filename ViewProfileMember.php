
<?php
session_start();
require_once  'Member.php';

if($_SESSION['id']){
  $member=new Member();
  echo $_SESSION['id'];
  $row=$member->ViewProfile($_SESSION['id']);
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
      <form method="post"></form>
        <label for="name">Name : </label><?php echo $row['FirstName'].' '.$row['LastName']; ?>
        <br><br>
        <label for="Email">Email : </label><?php echo $row['Email']; ?>
        <br><br>
        <label for="PhoneNumber">Phone Number :   </label><?php echo '0'.$row['PhoneNumber']; ?>
        <br><br>
        <label for="PackageNumber">Number of current package enrolling in :   </label><?php echo $row['packageNo']; ?>
        <br><br>
        <label for="SessionTime">Session Time :   </label><?php echo 'From '.$row['SessionStartTime'].':00 To '.$row['SessionEndTime'].':00'; ?> 
        <br><br>
        <label for="StartDate">Start Date :  </label><?php echo $row['StartDate']; ?> 
        <br><br>
        <label for="EndDate">End Date :  </label><?php echo $row['EndDate']; ?> 
        <br><br>
        <label for="TrainerName">Trainer Name :  </label><?php echo $row['firstname'].' '.$row['lastname']; ?>
        <br><br>
      
       <input type="submit" name="submit" value="Edit Profile">  
      </form>
        
    </body>
</html>





