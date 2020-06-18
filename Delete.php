<?php
session_start();
require 'Admin.php';
$ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$admin= new Admin();
$UserType=filter_input(INPUT_GET,'UserType',FILTER_SANITIZE_STRING);
$admin->DeleteUser($ID);


if($UserType=='admin')
{
 header("Location:ViewAdmins.php");    
}else if($UserType=='member')
{
    header("Location:ViewMembers.php");
}else if($row['UserType']=='trainer')
{
    header("Location:ViewTrainers.php");
}
?>
