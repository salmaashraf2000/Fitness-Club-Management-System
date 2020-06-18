<?php

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
    </head>
    <body>
        <h1>List Members</h1>
        <form method="post">
            
            <input type="text" name="search" placeholder="Enter Name or Email to search"/>
            <input type="submit" value="Search"/>
        </form>
        
        <table cellpadding="8">
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
                    <td> <?php if($row['ProfilePicture']){ ?> <img src="../ProfilePicture/<?php echo $row['ProfilePicture']; ?>" style="width: 100px; height:100px"/>' <?php }else { echo 'No Image';} ?>  </td>
                    <td><a href="AdminEditMember.php?id=<?= $row['id']?>&packageNo=<?= $row['packageNo']?>&trainerID=<?= $row['trainerID']?>&SessionStartTime=<?= $row['SessionStartTime']?>&SessionEndTime=<?= $row['SessionEndTime']?>">Edit</a> | <a href="Delete.php?id=<?= $row['id']?>">Delete<a/></td>
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>-->



