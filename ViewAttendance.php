<?php

    include_once("AdminNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

        require_once 'Admin.php';
        require_once 'Validation.php';
        $trainerErr=$timeErr="";

        $admin= new Admin();
          
        //get all trainers
        $trainers =$admin->ViewTrainers();
        $valid=new Validation();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $trainerErr=$valid->Text($_POST['getTrainers']);
            $timeErr=$valid->Text($_POST['time']);





            if($trainerErr=="" && $timeErr=="")
            {

               $date=$_POST['Date'];
               
               //get the attendances' of the members of specified session, trainer and date
               $membersAttendance=$admin->ViewMembersAttendance($_POST['getTrainers'],$_POST['time'],$date);

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
             <h1>View Attendance</h1> 
    </div>    
    <div class="container">   
        <form method="post" action="<?=$_SERVER['PHP_SELF'];?>"  >
            <div class="form-group">  
             <label class="col-sm-2"> Trainer Name : </label>
             <div class="col-sm-4"> 
              <select name="getTrainers" required="true" class="form-control"> 
                <option value=""></option>
                <?php foreach ($trainers as $row){ 
                $name=$row['FirstName'].' '.$row['LastName'];
                echo "<option value=" .$row['id'].">" .$name. "</option>";
                } ?>
                
            </select><?php echo $trainerErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">  
             <label class="col-sm-2"> Session Time : </label>
             <div class="col-sm-4"> 
              <select  name="time" required="true" class="form-control">
                
                <option value=""></option>
                <option value="8-10">8:00 to 10:00</option>
                <option value="10-12">10:00 to 12:00</option>
                <option value="12-14">12:00 to 14:00</option>
                <option value="14-16">14:00 to 16:00</option>
                <option value="16-18">16:00 to 18:00</option>
                <option value="18-20">18:00 to 20:00</option>
                <option value="20-22">20:00 to 22:00</option>
                
            </select><?php echo $timeErr;?>
             </div>
         </div>
         <br><br>
         <div class="form-group">
                     <label class="col-sm-2">Date :</label> 
                     <div class="col-sm-4"> 
                     <input type="date" id="Date" class="form-control" name="Date" required>
                     </div>
            </div>
            <br><br>
        <input type="submit" name="btn"  value="Show Attendance"class="btn btn-primary">
        
            <br><br>
            
            <br><br>
        
             </form> 
      </div>
         
    <div class="container">   
        <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && $trainerErr=="" && $timeErr=="" && $membersAttendance){ ?>
        <table id="viewAttendance" name="viewAttendance"  cellpadding="8" class="table table-striped table-bordered">
            <thread>
                <tr>
                    <th>Member Name</th>
                    <th>Attendance</th>
             
                </tr>
            </thread>   
            <?php   foreach ($membersAttendance as $Row){ 
                 echo "<tr>";
                    echo '<td>'. $Row['FirstName'].' '.$Row['LastName'] .'</td>';
                    echo '<td>'. $Row['Attendance'] .'</td>';
                   
               echo "</tr>";    
             } ?>     
        </table>
        <br><br>
       <?php }else{
          echo 'No Results to show';
       } ?>  
    </div> 
    </body>
</html>



