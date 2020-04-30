<?php
require_once 'Person.php';
require_once 'Profile.php';
class Trainer extends Person implements Profile{
    
    private $TimeStartingShift;
    private $TimeEndingShift;
    
    public function getTimeStartingShift() {
        return $this->TimeStartingShift;
    }

    public function getTimeEndingShift() {
        return $this->TimeEndingShift;
    }

    public function setTimeStartingShift($TimeStartingShift) {
        $this->TimeStartingShift = $TimeStartingShift;
    }

    public function setTimeEndingShift($TimeEndingShift) {
        $this->TimeEndingShift = $TimeEndingShift;
    }

       /* use mysql
    {
        mysql::__construct as private __mysqlconstruct;
    }
    public function __construct()
    {
       // global $config;
       //$this->__mysqlconstruct($config);
    }*/
    
    //check if the session time belong to this trainer
    public function CheckIfSessionBelongToTrainer($sessionTime,$trainerID)
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
         $table='TrainersShiftInfo';
         $fields='TimeStartingShift,TimeEndingShift';
         $result=$this->select($table,"TrainerId=$trainerID AND TimeStartingShift<=$sessionStart AND TimeEndingShift>=$sessionEnd",$fields,'');
         if($this->countRows()==0)
         {
             
             return false;
         } else 
         {
             return $sessionStart;
         }
    }
    
    //get names of members of the current session
    public function GETMembersOfSession($sessionTime,$trainerID)
    {
        
        $sessionStart= $this->CheckIfSessionBelongToTrainer($sessionTime,/*$trainerID*/22);
     
        $sessionEnd=$sessionStart+2;
        if($sessionStart==false)
        {
            
            return 0;
        } 
        $taken=$this->CheckIfAttendanceIsTaken($sessionStart,$sessionEnd,/*$trainerID*/22);
        if($taken==true)
        {
            
            return -1;
        }
        
        $table1='EnrollementOfMember as e';
        $table2='UsersInformation as u';
        $fields='u.ID,u.FirstName,u.LastName';
        $currentDate= date("Y-m-d");
        $result= $this->selectJoin($table1,'',$fields,'',$table2,0,"e.MemberID=u.ID AND e.StartDate<='$currentDate' AND e.EndDate>='$currentDate' AND e.TrainerID=$trainerID AND e.SessionStartTime=$sessionStart AND e.SessionEndTime=$sessionEnd");
        echo $this->countRows();
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    
    
    //record the attendance of members
    public function TakeMembersAttendance(array $membersNames,array $checkedMembers,$TrainerId)
    {
        
        $currentDate= date("Y-m-d");
        $table='MembersAttendance';
        $sessionStart;
        $sessionEnd;
        $check=0;
       
        foreach ($membersNames as $row)
        {
            
           if($check==0)
           {
               
               $check=1;
               $table1='EnrollementOfMember';
               $fields='SessionStartTime,SessionEndTime';
               $memberId=$row['ID'];
               $result= $this->select($table1,"TrainerID=$TrainerId AND MemberID=$memberId AND StartDate<='$currentDate' AND EndDate>='$currentDate'",$fields,'');
              
               $Row= mysqli_fetch_assoc($result);
               
               $sessionStart=$Row['SessionStartTime'];
               $sessionEnd=$Row['SessionEndTime'];
               
              
               
            } 
           $attend=0;
           $id=$row['ID'];
           if(isset($checkedMembers[$id])){
               $attend=1;
               
           }   
           $data=array('TrainerId'=>$TrainerId,'MemberId'=>$row['ID'],'Attendance'=>$attend,'sessionStartTime'=>$sessionStart,'sessionEndTime'=>$sessionEnd,'Date'=>$currentDate);
           $this->insert($table,$data);
        }
    }
    
    //check if attendance already taken
    public function CheckIfAttendanceIsTaken($sessionStart,$sessionEnd,$TrainerId)
    {
        
        $table='MembersAttendance';
        $currentDate= date("Y-m-d");
        $result= $this->select($table,"TrainerId=$TrainerId AND sessionStartTime=$sessionStart AND sessionEndTime=$sessionEnd AND Date='$currentDate'");
        if($this->countRows()>0)
        {
            //attendance already taken
            return true;
        }else
        {
            return false;
        }
    }
    //view profile
    public function ViewProfile($ID)
    {
        $table1='UsersInformation as u';
        $table2='TrainersShiftInfo as t';
        $fields='u.FirstName,u.LastName,u.PhoneNumber,u.Email,t.TimeStartingShift,t.TimeEndingShift,t.packageNo';
        $result= $this->selectJoin($table1,'', $fields,'',$table2,0,"u.ID=t.TrainerId AND u.ID='$ID'");
        return mysqli_fetch_assoc($result);
    }
    /*//edit profile
    public function EditProfile($ID,$password,$phoneNumber) 
    {
        $table='UsersInformation';
        $data=array('PhoneNumber'=> $trainer->PhoneNumber,'Password'=>$trainer->Password);
        $this->update($table, $data,"ID=$ID");
    }*/
    //SELECT u.ID,u.FirstName,u.LastName FROM EnrollementOfMember as e LEFT JOIN UsersInformation as u ON e.MemberID=u.ID AND e.StartDate<='2020-04-25' AND e.EndDate>='2020-04-25' AND e.TrainerID=28 AND e.SessionStartTime=16 AND e.SessionEndTime=18
}
