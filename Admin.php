<?php
//require 'mysql.php';
//require 'config.php';
require 'person.php';
require 'Package.php';
require 'Member.php';
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
        //selectJoin($table1,$where='',$fields='*',$order='',$table2,$on1='',$table3='',$on2='');
        $fields='m.ID,m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,e.StartDate,e.EndDate,t.packageNo';
        $date= date("Y-m-d");
        $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber='"+$row['userTypeNumber']+"'",$fields,"","EnrollementOfMember as e","m.ID=e.MemberID  AND $date<=e.EndDate","TrainersShiftInfo as t","t.TrainerId=e.TrainerID"); 
       // $result= $this->selectJoin("UsersInformation as m","m.UserTypeNumber=3 AND $date<=e.EndDate",$fields,"","EnrollementOfMember as e","m.ID=e.MemberID","TrainersShiftInfo as t","t.TrainerId=e.TrainerID"); 

        return mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
    public function CheckIfPackageExist($packageNo){
        $this->select('Packages',"PackageNumber='$packageNo'",'*','');
        return $this->countRows();
    }
    
}
?>
