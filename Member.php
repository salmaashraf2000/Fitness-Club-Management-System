<?php
/*require 'mysql.php';
require 'config.php';*/
require_once 'Person.php';
require_once 'Profile.php';
class Member extends Person implements Profile{
    /*use mysql{
        mysql::__construct as private __mysqlconstruct;
    }
    public function __construct(){
       
       $this->__mysqlconstruct($config);
    }*/
    
    //view profile
    public function ViewProfile($ID)
    {
        
        $fields='m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,e.StartDate,e.EndDate,t.packageNo,tr.FirstName as firstname,tr.LastName as lastname';
        $date= date("Y-m-d");
        $usertype=$row['userTypeNumber'];
        $table1='UsersInformation as m';
        $table2='EnrollementOfMember as e';
        $table3='TrainersShiftInfo as t';
        $table4='UsersInformation as tr';
        $result= $this->selectJoin($table1,"m.ID='$ID'",$fields,"",$table2,1,"m.ID=e.MemberID AND '$date'>=e.StartDate AND '$date'<=e.EndDate",$table3,1,"t.TrainerId=e.TrainerID",$table4,1,"tr.ID=e.TrainerID"); 
        //$row=mysqli_fetch_assoc($result);
        //echo $row['FirstName']." ".$row['m.FirstName'];
        return  mysqli_fetch_assoc($result);
         
    }
    
        
    
}