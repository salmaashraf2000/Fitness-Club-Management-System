<?php

    include_once("AdminNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

        require 'Admin.php';

        $admin= new Admin();

        //get all members
        $members=$admin->ViewMembers();

        //if the admin searched for a member
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
                //result of the search is shown
                $members=$admin->SearchMember($_POST['search']);

        }
    }else
    {
        echo "<script>alert('Must login');
             window.location.href='index.php';
              </script>";
    }
?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Members</title>
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
             <h1>List Members</h1>
    </div>    
    <div class="container">
        <form method="post">
            <div class="form-group">   
                 
                 <div class="col-sm-4"> 
                  <input type="text" name="search" placeholder="Enter Name or Email to search" class="form-control"/>
                 </div>
                 <div class="col-sm-4"> 
                   <input type="submit" class="btn btn-primary" name="submit" value="Search" >  
                 </div>
             </div>
         <br><br>
        
         
        </form>
        
        <table cellpadding="8" class="table table-striped table-bordered">
            <thread>
                <tr>
                    <th>Member Name</th>  
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Current Package Number Enrolling in</th>
                    <th>Session Start Time</th>
                    <th>Session End Time</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Trainer Name</th>
                    <th>Profile Picture</th>
                    
                </tr>
            </thread>   
            <?php            foreach ($members as $row){ ?>
                <tr>
                    <td><?= $row['FirstName'].' '.$row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    <td><?= $row['packageNo']?></td>
                    <td><?= $row['SessionStartTime']?></td>
                    <td><?= $row['SessionEndTime']?></td>
                    <td><?= $row['StartDate']?></td>
                    <td><?= $row['EndDate']?></td>
                    <td><?= $row['firstname'].' '.$row['lastname']?></td>
                    <td> <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo 'No Picture';} ?>  </td>
                    <td><a class="btn btn-primary" href="AdminEditMember.php?id=<?= $row['id']?>&packageNo=<?= $row['packageNo']?>&trainerID=<?= $row['trainerID']?>&SessionStartTime=<?= $row['SessionStartTime']?>&SessionEndTime=<?= $row['SessionEndTime']?>">Edit</a> | <a class="btn btn-primary" href="Delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
    </div>
    </body>
</html>



