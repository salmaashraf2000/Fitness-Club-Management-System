<?php

    include_once("MemberNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='member')
    {
        require 'Admin.php';


        $member= new Member();
        
        //get all trainers
        $trainers=$member->ViewTrainers();


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
        <title>List Trainers</title>
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
             <h1>List Trainers</h1> 
        </div>    
        <div class="row"> 
            
         <?php            foreach ($trainers as $row){ ?>  
                  
              <div class="col-sm-3 ">
  
              <div class="card" style="width: 18rem;">
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 150px; height:150px"/>' <?php }else { echo '<img  src="https://www-nomadcruise-com.exactdn.com/wp-content/uploads/22-223930_avatar-person-neutral-man-blank-face-buddy-facebook.png" style="width: 150px; height:150px""> ';} ?></li>
                <li class="list-group-item">Name: <?= $row['FirstName'].' '.$row['LastName']?></li>
                <li class="list-group-item">Phone Number: <?= '0'.$row['PhoneNumber']?></li>
                <li class="list-group-item">Email: <?= $row['Email']?></li>
                <li class="list-group-item">Package Number: <?= $row['packageNo']?></li>
                <li class="list-group-item">Shift: <?= 'From '.$row['TimeStartingShift'].':00'.' To '.$row['TimeEndingShift'].':00'?></li>
                
              </ul>
             </div>
            </div>
        <?php } ?> 
      </div>   
    </body>
</html>

 

   