<?php
require 'Admin.php';
$admin= new Admin();
$membersAttendance=$admin->ViewMembersAttendance(28,"4-6","04/23/2020");
echo $admin->countRows();
foreach ($membersAttendance as $Row){
              
    echo  $Row['FirstName'].' '.$Row['LastName'].' '.$Row['Attendance'];
}
                   
