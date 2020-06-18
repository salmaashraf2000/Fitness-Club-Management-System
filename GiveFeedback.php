<?php



    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='member'){

        require_once 'Admin.php';
        require_once 'Validation.php';
        require_once 'Feedback.php';
        $trainerErr="";
        $feedbackText="";
        $feedbackErr="";
        $msg="";
        
        $member=new Member();
        $valid=new Validation();
        $feedback= new FeedBack();  
        //get all trainers
        $trainers =$member->ViewTrainers();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST['Feedback']=$valid->test_input($_POST['Feedback']);
            
            
            $trainerErr=$valid->Text($_POST['getTrainers']);
            
            $feedbackText=$_POST['Feedback'];
            if($trainerErr=="" && $feedbackErr=="")
            {
                 $feedback->setFeedback($_POST['Feedback']);
                 $feedback->setMemberID($_SESSION['id']);
                 $feedback->setTrainerID($_POST['getTrainers']);
                 
                 //record the feedback
                 $check=$member->GiveFeedback($feedback);  

                 if($check==true)
                 {
                     $msg='Feedback recorded successfully';
                 }else
                 {
                     //member did not train with this trainer
                     $msg='Faild to record your feedback';
                 }
                 echo "<script type='text/javascript'>alert('$msg');</script>";
            }
        }
    }else
    {
        echo "<script>alert('Must login');
             window.location.href='index.php';
              </script>";
    }

?>

</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
     <form method="post"> 
         
         Trainer Name : <select name="getTrainers">
                <option value=""></option>
                <?php foreach ($trainers as $row){ 
                $name=$row['FirstName'].' '.$row['LastName'];
                echo "<option value=" .$row['ID'].">" .$name. "</option>";
                } ?>
                </select><?php echo $trainerErr;?>
         <br><br>
         <textarea name="Feedback" rows="5" cols="40" ><?php  echo $feedbackText;?></textarea><?php echo $feedbackErr;?>
         <br><br>
         <input type="submit" name="submit" value="Submit" >
     </form>
        
    </body>
</html>









