<?php

require_once 'person.php';
require_once 'Package.php';
require_once 'Member.php';
require_once  'Trainer.php';
require_once 'Profile.php';
class Admin extends Person implements Profile{
    
    
    public function __construct()
    {
       
    }
   
    //add member
    public function AddMember(Member $member)
    {
        $this->SendEmail($member->Email, $member->Password);
        $member->Password= password_hash($member->Password, PASSWORD_DEFAULT);
        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$member->FirstName,'LastName'=>$member->LastName,'PhoneNumber'=>$member->PhoneNumber,'Email'=>$member->Email,'Password'=>$member->Password,'Age'=>$member->Age,'Gender'=>$member->Gender,'UserTypeNumber'=>$row['userTypeNumber'],'FirstLogin'=>0);
        $table='UsersInformation';
        $this->insert($table, $fields);
        
    }
    //add admin
    public function AddAdmin(Admin $admin)
    {
        $this->SendEmail($admin->Email, $admin->Password);
        $admin->Password=password_hash($admin->Password, PASSWORD_DEFAULT);
        $result= $this->select("UsersType","UserType='admin'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$admin->FirstName,'LastName'=>$admin->LastName,'PhoneNumber'=>$admin->PhoneNumber,'Email'=>$admin->Email,'Password'=>$admin->Password,'Age'=>$admin->Age,'Gender'=>$admin->Gender,'UserTypeNumber'=>$row['userTypeNumber'],'FirstLogin'=>0);
        $table='UsersInformation';
        $this->insert($table, $fields);
        
    }
    
    //add trainer
    public function AddTrainer(Trainer $trainer,$packageNo)
    {
        $this->SendEmail($trainer->Email, $trainer->Password);
        $trainer->Password=password_hash($trainer->Password, PASSWORD_DEFAULT);    
        $result= $this->select("UsersType","UserType='trainer'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$trainer->FirstName,'LastName'=>$trainer->LastName,'PhoneNumber'=>$trainer->PhoneNumber,'Email'=>$trainer->Email,'Password'=>$trainer->Password,'Age'=>$trainer->Age,'Gender'=>$trainer->Gender,'UserTypeNumber'=>$row['userTypeNumber'],'FirstLogin'=>0);
        $table='UsersInformation';
        $this->insert($table, $fields);
        $trainer->ID= $this->getInsertedId();
        //$trainer->setTimeStartingShift($startShift);
        //$trainer->setTimeEndingShift($endShift);
        $fields1=array('TrainerId'=>$trainer->ID,'TimeStartingShift'=>$trainer->getTimeStartingShift(),'packageNo'=>$packageNo,'TimeEndingShift'=>$trainer->getTimeEndingShift());
        $table='TrainersShiftInfo';
        $this->insert($table, $fields1);
            
        
    }
    
    //add new package
    public function AddPackage(Package $package)
    {
        $fields=array('PackageInfo'=>$package->getPackageInfo(),'JacuzziNo'=>$package->getJacuzziNo(),'SpaNo'=>$package->getSpaNo(),'SteamNo'=>$package->getSteamNo(),'SaunaNo'=>$package->getSaunaNo(),'NumberOfMonths'=>$package->getNumberOfMonths(),'Price'=>$package->getPrice(),'Discount'=>$package->getDiscount());
        $table='Packages';
        $this->insert($table, $fields);
    }

    //view all members details
    public function ViewMembers()
    {
        

        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='m.ID as id,m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,e.StartDate,e.EndDate,t.packageNo,tr.FirstName as firstname,tr.LastName as lastname,tr.ID as trainerID,p.ProfilePicture as ProfilePicture';
        $date= date("Y-m-d");
        $usertype=$row['userTypeNumber'];
        $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber=$usertype",$fields,"","EnrollementOfMember as e",1,"m.ID=e.MemberID AND  '$date'>=e.StartDate AND '$date'<=e.EndDate","TrainersShiftInfo as t",1,"t.TrainerId=e.TrainerID","UsersInformation as tr",1,"tr.ID=e.TrainerID","ProfilePictures as p",1,"m.id=p.UserID"); 

        return mysqli_fetch_all($result,MYSQLI_ASSOC);
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
        
        $result= $this->select("UsersType","UserType='trainer'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='t.ID as id,t.FirstName,t.LastName,t.PhoneNumber,t.Email,s.TimeStartingShift,s.TimeEndingShift,s.packageNo,p.ProfilePicture as ProfilePicture';
        $usertype=$row['userTypeNumber'];
        $result= $this->selectJoin("UsersInformation as t","t.UserTypeNumber=$usertype",$fields,"","TrainersShiftInfo as s",0,"t.ID=s.TrainerId","ProfilePictures as p",1,"t.id=p.UserID"); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //view admins
    public function ViewAdmins()
    {
        
        $result= $this->select("UsersType","UserType='admin'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='a.ID as id,a.FirstName as FirstName,a.LastName as LastName,a.PhoneNumber as PhoneNumber,a.Email as Email,p.ProfilePicture as ProfilePicture';
        $usertype=$row['userTypeNumber'];
        $result= $this->selectJoin("UsersInformation as a","UserTypeNumber=$usertype",$fields,"","ProfilePictures as p",1,"a.ID=p.UserID"); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //get name and id for all tainers working
    public function GetTrainers()
    {
        $table1="TrainersShiftInfo as t";
        $table2="UsersInformation as u";
        $fields="u.FirstName,u.LastName,u.ID";
        $result= $this->selectJoin($table1,'',$fields,'',$table2,0,'u.ID=TrainerId');
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
        $table1='MembersAttendance as a';
        $table2='UsersInformation as u';
        $fields='u.FirstName,u.LastName,a.Attendance';
        $result= $this->selectJoin($table1,"a.Date='$date' AND a.sessionStartTime=$sessionStart AND a.sessionEndTime=$sessionEnd AND a.TrainerId=$trainerID",$fields,'',$table2,0,'u.ID=a.MemberId');
        
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
   
    //view profile of admin
    public function ViewProfile($ID)
    {
        $table1='UsersInformation as u';
        $table2='ProfilePictures as p';
        $fields='u.FirstName,u.LastName,u.PhoneNumber,u.Email,p.ProfilePicture';
        $result= selectJoin($table1,'',$fields,'',$table2,$left1=1,$on1="u.ID=p.UserID AND u.ID=$ID");
        return mysqli_fetch_assoc($result);
    }
    
    //view packages
    public function ViewPackages()
    {
        $table='Packages';
        $result= $this->select($table,'','*','');
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
   
     
    //check if any member is training with specific trainer
    public function CheckIfAnyMemberEnrollWithTrainer($ID)
    {
        $table='EnrollementOfMember';
        $date= date("Y-m-d");
        $result= $this->select($table,"TrainerID='$ID' AND StartDate<='$date' AND EndDate>='$date'");
        if($this->countRows()>0)
        {
            return true;
        }
        return false;
    }
    
    //change package and shift trainer working in
    public function EditTrainer($id,$shift,$PackageNumber)
    {
        $table='TrainersShiftInfo';
        $startShift;
        $endShift;
         if($shift==='morning')
         {
         $startShift=8;
         $endShift=14;

        } else 
        {
         $startShift=14;
         $endShift=22;
         
        }
        $data= array('TimeStartingShift'=>$startShift,'TimeEndingShift'=>$endShift,'packageNo'=>$PackageNumber);
        $this->update($table, $data, "TrainerId='$id'");
    }

  
    //delete package
    public function DeletePackage($PackageNumber)
    {
        $table='Packages';
        $this->delete($table,"PackageNumber='$PackageNumber'");
    }
    
    //specify user type
    public function UserType($ID)
    {
        
        $table1='UsersType as t';
        $table2='UsersInformation as u';
        $fields='t.UserType';
        $result= $this->selectJoin($table1,'', $fields,'', $table2,0, "t.userTypeNumber=u.UserTypeNumber AND u.ID=$ID");
        echo $this->countRows();
        return mysqli_fetch_assoc($result);
    }
    
    
    //edit information of a package
    public function EditPackage($package,$PackageNumber)
    {
        $table='Packages';
        $data=array('PackageInfo'=>$package->getPackageInfo(),'JacuzziNo'=>$package->getJacuzziNo(),'SpaNo'=>$package->getSpaNo(),'SteamNo'=>$package->getSteamNo(),'SaunaNo'=>$package->getSaunaNo(),'NumberOfMonths'=>$package->getNumberOfMonths(),'Price'=>$package->getPrice(),'Discount'=>$package->getDiscount());
        $this->update($table, $data, "PackageNumber=$PackageNumber");
    }
    //search for a member by email or name
    public function SearchMember($search)
    {
        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $usertype=$row['userTypeNumber'];
        $fields='m.ID as id,m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,e.StartDate,e.EndDate,t.packageNo,tr.FirstName as firstname,tr.LastName as lastname';
        $date= date("Y-m-d");
        $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber=$usertype AND (m.FirstName LIKE '%$search%' OR m.Email LIKE '%$search%' OR m.LastName LIKE '%$search%')",$fields,"","EnrollementOfMember as e",1,"m.ID=e.MemberID AND  '$date'>=e.StartDate AND '$date'<=e.EndDate ","TrainersShiftInfo as t",1,"t.TrainerId=e.TrainerID","UsersInformation as tr",1,"tr.ID=e.TrainerID"); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //search for a trainer by email or name
    public function SearchTrainer($search)
    {
        $result= $this->select("UsersType","UserType='trainer'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='t.ID as id,t.FirstName,t.LastName,t.PhoneNumber,t.Email,s.TimeStartingShift,s.TimeEndingShift,s.packageNo';
        $usertype=$row['userTypeNumber'];
        $result= $this->selectJoin("UsersInformation as t","t.UserTypeNumber=$usertype AND (t.FirstName LIKE '%$search%' OR t.Email LIKE '%$search%' OR t.LastName LIKE '%$search%')",$fields,"","TrainersShiftInfo as s",0,"t.ID=s.TrainerId"); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    //search for an admin by email or name
    public function SearchAdmin($search)
    {
        $result= $this->select("UsersType","UserType='admin'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields='ID as id,FirstName,LastName,PhoneNumber,Email';
        $usertype=$row['userTypeNumber'];
        $result= $this->select("UsersInformation","UserTypeNumber=$usertype AND (FirstName LIKE '%$search%' OR Email LIKE '%$search%' OR LastName LIKE '%$search%')",$fields); 
        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    
    //get all available sessions in a package
    public function GetAvailableSessions($PackageNumber)
    {
        $table1='TrainersShiftInfo as t';
        $table2='UsersInformation as u';
        $Fields='t.TrainerId,t.packageNo,t.TimeStartingShift,t.TimeEndingShift,u.FirstName,u.LastName';
        $result= $this->selectJoin($table1,"packageNo=$PackageNumber",$Fields,'',$table2,0,"t.TrainerId=u.ID");
        $trainers=mysqli_fetch_all($result,MYSQLI_ASSOC);
        $Sessions=array();
        $table='EnrollementOfMember';
        $date= date("Y-m-d");
        foreach ($trainers as $trainer)
        {
            $trainerId=$trainer['TrainerId'];
            $name=$trainer['FirstName'].' '.$trainer['LastName'];
            for($Time=$trainer['TimeStartingShift'];$Time<$trainer['TimeEndingShift'];$Time+=2)
            {
                $fields='COUNT(MemberID) as NumberOfTrainees';
                $Result= $this->select($table, "TrainerID=$trainerId AND StartDate<='$date' AND EndDate>='$date' AND SessionStartTime=$Time", $fields,'');
                $row=mysqli_fetch_assoc($Result);
                
                if($row['NumberOfTrainees']<31)
                {
                    
                    $Sessions[]=array($name,$trainer['TrainerId'],$Time,$Time+2);
                    
                }
                
            }
        }
        return $Sessions;
    }
    
    //edit member session
    public function EditMember($ID,$SessionTime)
    {
        $arr=explode('/', $SessionTime);
        $table='EnrollementOfMember';
        $data=array('TrainerID'=>$arr[0],'SessionStartTime'=>$arr[1],'SessionEndTime'=>$arr[1]+2);
        $this->update($table, $data, "MemberID=$ID");
    }
    
    //send email with credentials
    public function SendEmail($email,$pass)
    {
      
        $message="Hello, welcome to our site you can login using these credentails, Email:.$email. Password:.$pass. then you will need to change the password";
        $message= wordwrap($message,70);
        mail($email,"Login Credentials",$message);
    }
}
?>
