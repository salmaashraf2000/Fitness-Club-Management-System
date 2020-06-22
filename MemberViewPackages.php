<?php
     
    include_once("MemberNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='member')
    {
        
        require_once 'Member.php';
        $member=new Member();
        
        //get all packages
        $packages=$member->ViewPackages();
        
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
        <title>List Packages</title>
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
             <h1>List Packages</h1> 
        </div>    
      <div class="row"> 
        <?php            foreach ($packages as $row){ ?>  
            <div class="col-sm-3 ">
  
                    <div class="card" style="width: 18rem;">

              <ul class="list-group list-group-flush">
                <li class="list-group-item"><img src="https://media-cdn.tripadvisor.com/media/photo-s/02/b1/c3/54/filename-planet-gym-jpg.jpg" style="width: 100px; height:100px"/></li>  
                <li class="list-group-item">Package Number: <?= $row['PackageNumber']?></li>
                <li class="list-group-item">Package Description: <?= $row['PackageInfo']?></li>
                <li class="list-group-item">Number of Jacuzzi sessions: <?= $row['JacuzziNo']?></li>
                <li class="list-group-item">Number of Spa sessions: <?= $row['SpaNo']?></li>
                <li class="list-group-item">Number of Steam sessions: <?= $row['SteamNo']?></li>
                <li class="list-group-item">Number of Sauna sessions: <?= $row['SaunaNo']?></li>
                <li class="list-group-item">Number Of Months: <?= $row['NumberOfMonths']?></li>
                <li class="list-group-item">Price: <?= $row['Price']?></li>
                <li class="list-group-item">Discount: <?= $row['Discount']?></li>
              
             
                <li class="list-group-item"><a class="btn btn-primary" href="EnrollInPackage.php?PackageNumber=<?= $row['PackageNumber']?>&NumberOfMonths=<?= $row['NumberOfMonths']?>" class="card-link">Enroll</a></li>
              </ul>
              </div>
              </div>
            
        <?php } ?> 
      </div>   
    </body>
</html>