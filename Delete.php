<?php
require 'Admin.php';
$ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$admin= new Admin();
$admin->DeleteUser($ID);


