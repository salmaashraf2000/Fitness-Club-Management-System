<?php

require 'Admin.php';

//session_start();
$admin= new Admin();
$members=$admin->ViewMembers();

?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Members</title>
    </head>
    <body>
        <h1>List Members</h1>
        <table cellpadding="8">
            <thread>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Current Package Number Enrolling in</th>
                    <th>Session Start Time</th>
                    <th>Session End Time</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Trainer First Name</th>
                    <th>Trainer Last Name</th>
                    
                </tr>
            </thread>   
            <?php            foreach ($members as $row){ ?>
                <tr>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    <td><?= $row['packageNo']?></td>
                    <td><?= $row['SessionStartTime']?></td>
                    <td><?= $row['SessionEndTime']?></td>
                    <td><?= $row['StartDate']?></td>
                    <td><?= $row['EndDate']?></td>
                    <td><?= $row['firstname']?></td>
                    <td><?= $row['lastname']?></td>
                    <td><a href="edit.php?id=<?= $row['id']?>">Edit</a> | <a href="delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



