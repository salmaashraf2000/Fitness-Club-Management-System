<?php

require_once 'Person.php';
require_once 'Profile.php';
require_once 'Admin.php';
require_once 'Feedback.php';
require_once 'Enrollment.php';
require_once 'Payment.php';
class Member extends Person implements Profile{
   
    //signup
     public function SignUp(Member $member)
    {
        
        $member->Password= password_hash($member->Password, PASSWORD_DEFAULT);
        $result= $this->select("UsersType","UserType='member'",'userTypeNumber',''); 
        $row= mysqli_fetch_assoc($result);
        $fields=array('FirstName'=>$member->FirstName,'LastName'=>$member->LastName,
        'PhoneNumber'=>$member->PhoneNumber,'Email'=>$member->Email,'Password'=>$member->Password,
        'Age'=>$member->Age,'Gender'=>$member->Gender,'UserTypeNumber'=>$row['userTypeNumber'],'FirstLogin'=>1);
        $table='UsersInformation';
        $this->insert($table, $fields);
        $_SESSION['id']=$this->getInsertedId();
        $_SESSION['FirstName']=$member->FirstName;
        $_SESSION['LastName']=$member->LastName;
        $_SESSION['FirstLogin']=1;
        $_SESSION['UserType']='member';
        
    }
    //member view profile
    public function ViewProfile($ID)
    {
        
        $fields='m.FirstName,m.LastName,m.PhoneNumber,m.Email,e.SessionStartTime,e.SessionEndTime,
        e.StartDate,e.EndDate,t.packageNo,tr.FirstName as firstname,tr.LastName as lastname,
        p.ProfilePicture as ProfilePicture';
        $date= date("Y-m-d");
        $usertype=$row['userTypeNumber'];
        $table1='UsersInformation as m';
        $table2='EnrollementOfMember as e';
        $table3='TrainersShiftInfo as t';
        $table4='UsersInformation as tr';
        $table5='ProfilePictures as p';
        $result= $this->selectJoin($table1,"m.ID='$ID'",$fields,"",$table2,1,
        "m.ID=e.MemberID AND '$date'>=e.StartDate AND '$date'<=e.EndDate",$table3,1,
        "t.TrainerId=e.TrainerID",$table4,1,"tr.ID=e.TrainerID",$table5,1,"m.ID=p.UserID"); 
       
        return  mysqli_fetch_assoc($result);
         
    }
    //delegation pattern
    public function ViewTrainers()
    {
        $admin=new Admin();
        return $admin->ViewTrainers();
    }
    
    //delegation pattern
    public function ViewPackages()
    {
        $admin=new Admin();
        return $admin->ViewPackages();
    }
    
    //delegation pattern 
    //get all available sessions in a package
    public function GetAvailableSessions($PackageNumber)
    {
        $admin=new Admin();
        return $admin->GetAvailableSessions($PackageNumber);
    }
    
   
          

    //give feedback
    public function GiveFeedback($feedback)
    {
        $trainerID=$feedback->getTrainerID();
        $memberID=$feedback->getMemberID();
        $result= $this->select("EnrollementOfMember","TrainerID=$trainerID AND MemberID=$memberID",'*',''); 
        if($this->countRows()>0)
        {
            
            $table='MembersFeedback';
            $fields=array('Memberid'=>$feedback->getMemberID(),'trainerid'=>$feedback->getTrainerID(),'Feedback'=>$feedback->getFeedback());
            $this->insert($table, $fields);
            return true;
        }
        return false;
    }
    
    //enroll in a packege
    public function EnrollInPackage($enroll)
    {
        
            $table='EnrollementOfMember';
            $fields=array('MemberID'=>$_SESSION['id'],'TrainerID'=>$enroll->getTrainerID(),'SessionStartTime'=>$enroll->getSessionStartTime(),'SessionEndTime'=>$enroll->getSessionEndTime(),'StartDate'=>$enroll->getStartDate(),'EndDate'=>$enroll->getEndDate(),'Payment'=>$enroll->getPayment());
            $this->insert($table, $fields);
    }
    

}