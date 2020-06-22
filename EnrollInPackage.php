<?php
    
    include_once("MemberNavigationBar.html");
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
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="Styles.css">
        <style>
            body {
               background: url('https://image.freepik.com/free-photo/blur-gym-fitness_74190-4444.jpg')no-repeat center center fixed;
               background-size: cover;
               
              
            }
        </style>

    </head>
    <body>
     <div class="container"> 
             <h1>Enroll in a package</h1> 
    </div>    
    <div class="container">     
    <form method="post">  
   
        <div class="form-check">  
            <label class="col-sm-2"> Sessions Time : </label> <?php echo $SessionErr;?>
            <div class="col-sm-4"> 
               <?php    $rows = count($sessions);
                    for($row=0;$row<$rows;$row++) 
                    {  ?>

                       <input type="radio"  name="SessionsTime"  required="true" value="<?php echo $sessions[$row][1].'/'.$sessions[$row][2]; ?>" ><?php echo $sessions[$row][2].':00 '.$sessions[$row][3].':00 ('.$sessions[$row][0].')'; ?>
                       <br><br>
           <?php    } ?>
            </div>
        </div>      
        <br><br>
        <div class="form-check">  
            <label class="col-sm-2">Payment: </label>
            <div class="col-sm-4"> 
              <input type="radio" name="Payment"  value="cash" required="true" >Cash
              <br><br>
              <input type="radio" name="Payment" value="electronic"  >Electronic
              <br><br><?php echo $PaymentErr;?>
              </div>
        </div>
        <br><br>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  

    </form>
     </div>     
    </body>
</html>