<?php


    session_start();

    ///check if a member is loggedin
    if($_SESSION['id'] && $_SESSION['UserType']=='member'){

      require_once  'Member.php';


      $member=new Member();
      //get the data of the memeber
      $row=$member->ViewProfile($_SESSION['id']);

      //if the member clicked edit profile button 
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
        <br><br>
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





