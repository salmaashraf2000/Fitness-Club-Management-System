<?php

    include_once("AdminNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {
        require_once 'Admin.php';
        $admin=new Admin();
        
        //get all packages
        $packages=$admin->ViewPackages();

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
        <div class="container">
        <table cellpadding="8" class="table table-striped table-bordered">
            <thread>
                <tr>
                    <th>Package Number</th>
                    <th>Package Information</th>
                    <th>Number of Jacuzzi sessions</th>
                    <th>Number of Spa sessions</th>
                    <th>Number of Steam sessions</th>
                    <th>Number of Sauna sessions</th>
                    <th>Number Of Months</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Email</th>
               
                    
                </tr>
            </thread>   
            <?php            foreach ($packages as $row){ ?>
                <tr>
                    <td><?= $row['PackageNumber']?></td>
                    <td><?= $row['PackageInfo']?></td>
                    <td><?= $row['JacuzziNo']?></td>
                    <td><?= $row['SpaNo']?></td>
                    <td><?= $row['SteamNo']?></td>
                    <td><?= $row['SaunaNo']?></td>
                    <td><?= $row['NumberOfMonths']?></td>
                    <td><?= $row['Price']?></td>
                    <td><?= $row['Discount']?></td>
                    
                    
                    <td><a class="btn btn-primary" href="EditPackage.php?PackageNumber=<?= $row['PackageNumber']?>&PackageInfo=<?= $row['PackageInfo']?>&JacuzziNo=<?= $row['JacuzziNo']?>&SpaNo=<?= $row['SpaNo']?>&SteamNo=<?= $row['SteamNo']?>&SaunaNo=<?= $row['SaunaNo']?>&NumberOfMonths=<?= $row['NumberOfMonths']?>&Price=<?= $row['Price']?>&Discount=<?= $row['Discount']?>">Edit</a> |<a class="btn btn-primary" href="DeletePackage.php?PackageNumber=<?= $row['PackageNumber']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        </div>
    </body>
</html>
