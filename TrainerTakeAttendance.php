<?php
session_start();
require 'Trainer.php';

$l= $_SESSION['time'];
echo $l;
$TrainerId=$_SESSION['id'];
 $trainer= new Trainer();
    $membersNames=$trainer->GETMembersOfSession($_SESSION['time'],$TrainerId);
if($membersNames==-1)
{  
    echo 'Attendance already taken'; 
}else if($membersNames==0)
{
    echo 'you are not allowed to take attendance of this session'; 
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
            
                $trainer->TakeMembersAttendance($membersNames,$checkedMembers,$TrainerId);
            }
             else{
                echo 'No Results to show';
            }  
          
       
    }
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
</html>
