<?php

require 'Admin.php';
$ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$admin= new Admin();
$row=$admin->UserType($ID);
$admin->DeleteUser($ID);


if($row['UserType']=='admin')
{
 header("Location:ViewAdmins.php");    
}else if($row['UserType']=='member')
{
    header("Location:ViewMembers.php");
}else if($row['UserType']=='trainer')
{
    header("Location:ViewTrainers.php");
}
?>
