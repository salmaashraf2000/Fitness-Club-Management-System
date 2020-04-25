<?php
require 'Trainer.php';
$trainer= new Trainer();
$Err="";
        
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  
   
    if( $_POST['getTrainers']=="")
    {
        $Err='*This field must be selected';
    }
   
    if($Err==""){
      
        $membersAttendance=$admin->ViewMembersAttendance($_POST['time']);
    }
}

?>



<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="<?=$_SERVER['PHP_SELF'];?>"  >
            
            Session Time : <select  name="time">
                
                <option value=""></option>
                <option value="8-10">8:00 to 10:00</option>
                <option value="10-12">10:00 to 12:00</option>
                <option value="12-14">12:00 to 14:00</option>
                <option value="14-16">14:00 to 16:00</option>
                <option value="16-18">16:00 to 18:00</option>
                <option value="18-20">18:00 to 20:00</option>
                <option value="20-22">20:00 to 20:00</option>
                
            </select><?php echo $Err;?>
            <br><br>
        
             </form> 
        
        <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && $Err=="" && $membersAttendance){ ?>
       
            <?php   foreach ($membersAttendance as $row){ ?>
        <input type="checkbox" name="<?php $row['ID']?>" value="<?php $row['ID'] ?>" ><?php $row['FirstName'].' '.$row['LastName'] ?>
                
             <?php } ?>     
        
       <?php }else{
          echo 'No Results to show';
       } ?>  
    </body>
</html>
