<?php
require 'Person.php';
class Trainer extends Person{
    
    public $TimeStartingShift;
    public $TimeEndingShift;
    use mysql
    {
        mysql::__construct as private __mysqlconstruct;
    }
    public function __construct()
    {
        global $config;
       $this->__mysqlconstruct($config);
    }
    
    //get names of members of the current session
    public function GETMembersOfSession($sessionTime,$trainerID)
    {
        $sessionStart;
        $sessionEnd;
        if($sessionTime==='8-10')
        {
            $sessionStart=8;
            $sessionEnd=10;
        }else if($sessionTime==='10-12')
        {
            $sessionStart=10;
            $sessionEnd=12;
        }else if($sessionTime==='12-14')
        {
            $sessionStart=12;
            $sessionEnd=14;   
        }else if($sessionTime==='14-16')
        {
            $sessionStart=14;
            $sessionEnd=16;
        }else if($sessionTime==='16-18')
        {
            $sessionStart=16;
            $sessionEnd=18;
        }else if($sessionTime==='18-20')
        {
            $sessionStart=18;
            $sessionEnd=20;
        }else
        {
            $sessionStart=20;
            $sessionEnd=22;
        }
        $table1='EnrollementOfMember as e';
        $table2='UsersInformation as u';
        $fields='u.ID,u.FirstName,u.LastName';
        $currentDate= date("Y-m-d");
        $result= $this->selectJoin($table1,'',$fields,'',$table2,"u.ID=e.MemberID AND $currentDate<=e.EndDate AND $trainerID=e.TrainerID");
        return  mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //check if the session time belong to this trainer
    public function CheckIfSessionBelongToTrainer()
    {
         
    }
    //selectJoin($table1,$where='',$fields='*',$order='',$table2,$on1='',$table3='',$on2='',$table4='',$on3='')
}
