<?php
 
require_once 'Member.php';
$member=new Member();
$packages=$member->ViewPackages();
 
?>
 
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Packages</title>
    </head>
    <body>
        <h1>List Packages</h1>
        <table cellpadding="8">
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
                    <td><a href="AvailableSessions.php?id=<?= $row['id']?>&packageNo=<?= $row['packageNo']?>&trainerID=<?= $row['trainerID']?>&SessionStartTime=<?= $row['SessionStartTime']?>&SessionEndTime=<?= $row['SessionEndTime']?>">Edit</a> 
 
 
                </tr>    
            <?php } ?>     
        </table>
 
    </body>
</html>