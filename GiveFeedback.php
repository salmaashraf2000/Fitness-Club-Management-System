<?php


    include_once("MemberNavigationBar.html");
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
            
            $feedbackErr=$valid->Text($_POST["Feedback"]);
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
             <h1>Your Feedback</h1> 
    </div>    
    <div class="container">   
     <form method="post"> 
         <div class="row">
          <div class="form-group">
                     <label class="col-sm-2">Feedback: </label> 
                     
                         <textarea name="Feedback" rows="5" cols="40" placeholder="write your feedback on the trainer you selected" required="true"><?php  echo $feedbackText;?></textarea><?php echo $feedbackErr;?>
                     
           
            <br><br>
         
             <label class="col-sm-2">Trainer Name : </label>
             <div class="col-sm-4"> 
              <select name="getTrainers" class="form-control" required="true">
                <option value=""></option>
                <?php foreach ($trainers as $row){ 
                $name=$row['FirstName'].' '.$row['LastName'];
                echo "<option value=" .$row['id'].">" .$name. "</option>";
                } ?>
                </select><?php echo $trainerErr;?>
             </div>
         
         <br><br>
         
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
         </div>
     </form>
    </div>    
    </body>
</html>









