<?php

require 'Admin.php';

//session_start();
$admin= new Admin();
$trainers=$admin->ViewTrainers();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
        $trainers=$admin->SearchTrainer($_POST['search']);
    
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
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Package Number</th>
                    <th>Shift Start Time</th>
                    <th>Shift End Time</th>
                    
                    
                    
                </tr>
            </thread>   
            <?php            foreach ($trainers as $row){ ?>
                <tr>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    <td><?= $row['packageNo']?></td>
                    <td><?= $row['TimeStartingShift']?></td>
                    <td><?= $row['TimeEndingShift']?></td>
                    
                    <td><a href="AdminEditTrainer.php?id=<?= $row['id']?>&packageNo=<?= $row['packageNo']?>&TimeStartingShift=<?= $row['TimeStartingShift']?>&TimeEndingShift=<?= $row['TimeEndingShift']?>">Edit</a> | <a href="Delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



