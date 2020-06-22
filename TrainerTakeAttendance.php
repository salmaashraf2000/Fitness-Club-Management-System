<?php

    include_once("TrainerNavigationBar.html");
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='trainer')
    {

        require 'Trainer.php';

       
        $TrainerId=$_SESSION['id'];
        $trainer= new Trainer();
        
        //get names of the membeers of the session
        $membersNames=$trainer->GETMembersOfSession($_SESSION['time'],$TrainerId);
        
        if($membersNames==-1)
        {  
           
            echo "<script>alert('Attendance already taken');
             window.location.href='ViewMembersToTakeAttendance.php';
              </script>";
            
        }else if($membersNames==0)
        {
            
            echo "<script>alert('you are not allowed to take attendance of this session');
             window.location.href='ViewMembersToTakeAttendance.php';
              </script>";
        }    
        else if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {


            if(isset($_POST['submit']))
            {

                    if($membersNames) 
                    {

                        $checkedMembers=array();

                        foreach($_POST['check_list'] as $selected)
                        {

                            $checkedMembers[$selected]=1;
                        }

                        //record the attendance of members
                        $trainer->TakeMembersAttendance($membersNames,$checkedMembers,$TrainerId);
                    }
                     else
                     {
                        
                        echo "<script>alert('No Results to show');
                        window.location.href='ViewMembersToTakeAttendance.php';
                        </script>";
                        
                    }  


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
             <h1>Take Attendance</h1> 
    </div>    
    <div class="container"> 
       <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
          
           <div class="form-group">    
             <div class="col-sm-4"> 
               <?php  foreach ($membersNames as $row){ ?>
               <input type="checkbox"  name="check_list[]" value="<?php echo $row['ID']?>" > <?= $row['FirstName'].' '.$row['LastName'] ?>
               <br><br>
               <?php  } ?>  
             </div>
           </div>        
           <br><br>
           <input type="submit" class="btn btn-primary" name="submit" value="Submit">  

              
        </form>  
    </div>    
    </body> 
</html>
