<?php

require 'Admin.php';
$PackageNumber= filter_input(INPUT_GET,'PackageNumber',FILTER_SANITIZE_NUMBER_INT);
$admin= new Admin();
$admin->DeletePackage($PackageNumber);
header("Location:ViewPackages.php");

