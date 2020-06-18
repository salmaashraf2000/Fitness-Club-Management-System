<?php

    session_start();
    
    //check that admin is loggedin
    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {
        require 'Admin.php';

        
        $admin= new Admin();
        
        //get all trainers
        $trainers=$admin->ViewTrainers();
        
        //if admin searched for a trainer
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
                //get all trainers that match the search
                $trainers=$admin->SearchTrainer($_POST['search']);

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
        <title>List Trainers</title>
    </head>
    <body>
        <h1>List Trainers</h1>
        <form method="post">
            
            <input type="text" name="search" placeholder="Enter Name or Email to search"/>
            <input type="submit" value="Search"/>
        </form>
        <table cellpadding="8">
            <thread>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Package Number</th>
                    <th>Shift Start Time</th>
                    <th>Shift End Time</th>
                    <th>Profile Picture</th>
                    
                    
                </tr>
            </thread>   
            <?php            foreach ($trainers as $row){ ?>
                <tr>
                    <td><?= $row['FirstName'].' '.$row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    <td><?= $row['packageNo']?></td>
                    <td><?= $row['TimeStartingShift']?></td>
                    <td><?= $row['TimeEndingShift']?></td>
                    <td> <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo 'No Image';} ?> </td>
                    <td><a href="AdminEditTrainer.php?id=<?= $row['id']?>&packageNo=<?= $row['packageNo']?>&TimeStartingShift=<?= $row['TimeStartingShift']?>&TimeEndingShift=<?= $row['TimeEndingShift']?>">Edit</a> | <a href="Delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



