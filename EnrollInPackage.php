<?php

  session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='member')
    {

        require_once 'Validation.php';
        require_once  'Member.php';
        require_once 'Enrollment.php';
        require_once 'Payment.php';
        $PaymentErr="";
        $SessionErr="";
        $NumberOfMonths;
        $packageNo=filter_input(INPUT_GET,'PackageNumber',FILTER_SANITIZE_NUMBER_INT);
        $NumberOfMonths=filter_input(INPUT_GET,'NumberOfMonths',FILTER_SANITIZE_NUMBER_INT);
        
        $valid=new Validation();
        $member=new Member();  
        
        //get all available sessions of a specific package
        $sessions=$member->GetAvailableSessions($packageNo);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $PaymentErr=$valid->Radio($_POST["Payment"]);
            $SessionErr=$valid->Radio($_POST["SessionsTime"]);
            if($PaymentErr=="" && $SessionErr=="")
            {
                $arr=explode('/', $_POST['SessionsTime']);
                
                $payment=new Payment();
                
                if($_POST["Payment"]=='cash')
                {
                    $payment->setCash(true);
                } else 
                {
                    $payment->setElectronic(true);    
                }
                $enroll=new Enrollment($payment);
                $Startdate=date("Y-m-d");
                $EndDate=$enroll->CalculateEndDate($Startdate, $NumberOfMonths);
               
                $enroll->setSessionEndTime($arr[1]+2);
                $enroll->setSessionStartTime($arr[1]);
                $enroll->setStartDate($Startdate);
                $enroll->setEndDate($EndDate);
                $enroll->setTrainerID($arr[0]);
                
                //record enrollment data
                $member->EnrollInPackage($enroll);
                echo "<script>alert('Successfully enrolled');
                window.location.href='MemberViewPackages.php';
                </script>";

            }
        }
    }else
    {
        echo "<script>alert('Must login');
             window.location.href='index.php';
              </script>";
    }

?>


<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     <form method="post">  
     Sessions Time :   <?php echo $SessionErr;?>
       <br><br>
       
       <?php    $rows = count($sessions);
                for($row=0;$row<$rows;$row++) 
                {  ?>
      
                   <input type="radio"  name="SessionsTime"  value="<?php echo $sessions[$row][1].'/'.$sessions[$row][2]; ?>" ><?php echo $sessions[$row][2].':00 '.$sessions[$row][3].':00 ('.$sessions[$row][0].')'; ?>
                   <br><br>
       <?php    } ?>
                
                
           
  <br><br>
 
  <br><br>
  Payment:
  <input type="radio" name="Payment"  value="cash"  >Cash
   <br><br>
  <input type="radio" name="Payment" value="electronic"  >Electronic
  <br><br><?php echo $PaymentErr;?>
  
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>