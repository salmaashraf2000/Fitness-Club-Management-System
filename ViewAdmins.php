<?php

require 'Admin.php';

//session_start();
$admin= new Admin();
$admins=$admin->ViewAdmins();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
        $admins=$admin->SearchAdmin($_POST['search']);
    
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>List Admins</title>
    </head>
    <body>
        <h1>List Admins</h1>
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
                    <th>Profile Picture</th>
                    
                </tr>
            </thread>   
            <?php            foreach ($admins as $row){ ?>
                <tr>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['LastName']?></td>
                    <td><?= '0'.$row['PhoneNumber']?></td>
                    <td><?= $row['Email']?></td>
                    <td> <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo 'No Image';} ?> </td>
        
                    <td><a href="Delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



