<?php

require 'Admin.php';

//session_start();
$admin= new Admin();
$admins=$admin->ViewAdmins();

?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Trainers</title>
    </head>
    <body>
        <h1>List Trainers</h1>
        <table cellpadding="8">
            <thread>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
               
                    
                </tr>
            </thread>   
            <?php            foreach ($admins as $row){ ?>
                <tr>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    
                    <td><a href="delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



