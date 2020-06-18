<?php

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
    </head>
    <body>
        <h1>List Trainers</h1>
        
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
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>-->



