<?php
    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
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
    </head>
    <body>
       <form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
        <?php  foreach ($membersNames as $row){ ?>
           <input type="checkbox"  name="check_list[]" value="<?php echo $row['ID']?>" > <?= $row['FirstName'].' '.$row['LastName'] ?>
                   <br><br>
            <?php  } ?>     
           <br><br>
           <input type="submit" name="submit"  value="Submit">
            <br><br>
              
        </form>  
    </body> 
</html>-->
