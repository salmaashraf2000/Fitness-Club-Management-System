<?php
//require 'mysql.php';
//require 'config.php';
require 'person.php';
require 'Package.php';
require 'Member.php';
require 'Trainer.php';
class Admin extends Person{
    
    use mysql
    {
        mysql::__construct as private __mysqlconstruct1;
    }
    public function __construct()
    {
        global $config;
        //call trait constructor
       // parent::__construct($config);
       $this->__mysqlconstruct1($config);
    }
   
    //add member
    public function AddMember(Member $member)
    {
        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$member->FirstName,'LastName'=>$member->LastName,'PhoneNumber'=>$member->Password,'Email'=>$member->Email,'Password'=>$member->Password,'Age'=>$member->Age,'Gender'=>$member->Gender,'UserTypeNumber'=>$row['userTypeNumber']);
        $table='UsersInformation';
        $this->insert($table, $fields);
        
    }
    //add admin
    public function AddAdmin(Admin $admin)
    {
        $result= $this->select("UsersType","UserType='admin'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$admin->FirstName,'LastName'=>$admin->LastName,'PhoneNumber'=>$admin->Password,'Email'=>$admin->Email,'Password'=>$admin->Password,'Age'=>$admin->Age,'Gender'=>$admin->Gender,'UserTypeNumber'=>$row['userTypeNumber']);
        $table='UsersInformation';
        $this->insert($table, $fields);
        
    }
    
    //add trainer
    public function AddTrainer(Trainer $trainer,$packageNo,$startShift,$endShift)
    {
            
        $result= $this->select("UsersType","UserType='trainer'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$trainer->FirstName,'LastName'=>$trainer->LastName,'PhoneNumber'=>$trainer->PhoneNumber,'Email'=>$trainer->Email,'Password'=>$trainer->Password,'Age'=>$trainer->Age,'Gender'=>$trainer->Gender,'UserTypeNumber'=>$row['userTypeNumber']);
        $table='UsersInformation';
        $this->insert($table, $fields);
        $trainer->ID= $this->getInsertedId();
        $trainer->TimeStartingShift=$startShift;
        $trainer->TimeEndingShift=$endShift;
        $fields1=array('TrainerId'=>$trainer->ID,'TimeStartingShift'=>$trainer->TimeStartingShift,'packageNo'=>$packageNo,'TimeEndingShift'=>$trainer->TimeEndingShift);
        $table='TrainersShiftInfo';
        $this->insert($table, $fields1);
            
        
    }
    
    //add new package
    public function AddPackage(Package $package)
    {
        $fields=array('PackageInfo'=>$package->PackageInfo,'JacuzziNo'=>$package->JacuzziNo,'SpaNo'=>$package->SpaNo,'SteamNo'=>$package->SteamNo,'SaunaNo'=>$package->SaunaNo,'NumberOfMonths'=>$package->NumberOfMonths,'Price'=>$package->Price,'Discount'=>$package->Discount);
        $table='Packages';
        $this->insert($table, $fields);
    }

    //view all members details
    public function ViewMembers()
    {
        $member=new Member();

        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='m.ID as id,m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,e.StartDate,e.EndDate,t.packageNo,tr.FirstName as firstname,tr.LastName as lastname';
        $date= date("Y-m-d");
        $usertype=$row['userTypeNumber'];
       // $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber='"+$row['userTypeNumber']+"'",$fields,"","EnrollementOfMember as e","m.ID=e.MemberID  AND $date<=e.EndDate","TrainersShiftInfo as t","t.TrainerId=e.TrainerID"); 
        $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber=$usertype",$fields,"","EnrollementOfMember as e","m.ID=e.MemberID AND $date<=e.EndDate","TrainersShiftInfo as t","t.TrainerId=e.TrainerID","UsersInformation as tr","tr.ID=e.TrainerID"); 

        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    public function CheckIfPackageExist($packageNo){
        $this->select('Packages',"PackageNumber='$packageNo'",'*','');
        return $this->countRows();
    }
    
    //delete user
    public function DeleteUser($ID)
    {
        $table='UsersInformation';
        $this->delete($table,"ID=$ID");
    }
    
    //view all trainers
    public function ViewTrainers()
    {
        $trainer=new Trainer();
        $result= $this->select("UsersType","UserType='trainer'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='t.ID as id,t.FirstName,t.LastName,t.PhoneNumber,t.Email,s.TimeStartingShift,s.TimeEndingShift,s.packageNo';
        $usertype=$row['userTypeNumber'];
        $result= $this->selectJoin("UsersInformation as t","t.UserTypeNumber=$usertype",$fields,"","TrainersShiftInfo as s","t.ID=s.TrainerId"); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //view admins
    public function ViewAdmins()
    {
        
        $result= $this->select("UsersType","UserType='admin'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='ID as id,FirstName,LastName,PhoneNumber,Email';
        $usertype=$row['userTypeNumber'];
        $result= $this->select("UsersInformation","UserTypeNumber=$usertype",$fields); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //get all tainers working
    public function GetTrainers()
    {
        $table1="TrainersShiftInfo as t";
        $table2="UsersInformation as u";
        $fields="u.FirstName,u.LastName,u.ID";
        $result= $this->selectJoin($table1,'',$fields,'',$table2,'u.ID=TrainerId');
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //view attendance of members taken by trainer
    public function ViewMembersAttendance($trainerID,$sessionTime,$date)
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
        }else if($sessionTime==='12-2')
        {
            $sessionStart=12;
            $sessionEnd=2;   
        }else if($sessionTime==='2-4')
        {
            $sessionStart=2;
            $sessionEnd=4;
        }else if($sessionTime==='4-6')
        {
            $sessionStart=4;
            $sessionEnd=6;
        }else if($sessionTime==='6-8')
        {
            $sessionStart=6;
            $sessionEnd=8;
        }else
        {
            $sessionStart=8;
            $sessionEnd=10;
        }
        $table1='MembersAttendance as a';
        $table2='UsersInformation as u';
        $fields='u.FirstName,u.LastName,a.Attendance';
        //$r=date_format($date,"Y-m-d");
       // $date=  str_replace('/"', '-', $date);
        //$date= date("Y/m/d", strtotime($date)); 
        $date = new DateTime($date);
         $r = $date->format('Y-m-d');
        $result= $this->selectJoin($table1,"a.Date=$r AND a.sessionStartTime=$sessionStart AND a.sessionEndTime=$sessionEnd AND a.TrainerId=$trainerID",$fields,'',$table2,'u.ID=a.MemberId');
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    //selectJoin($table1,$where='',$fields='*',$order='',$table2,$on1='',$table3='',$on2='',$table4='',$on3='')
}
?>
