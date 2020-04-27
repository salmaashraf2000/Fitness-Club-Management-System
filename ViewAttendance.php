<?php

require 'Admin.php';
$Err="";
        
  $admin= new Admin();
  $trainers =$admin->GetTrainers();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  
   
    if( $_POST['getTrainers']=="")
    {
        $Err='*All fields must be selected';
    }
        
    if( $_POST['time']=="")
    {
        $Err='*All fields must be selected';    
    }
    
   
    
        
       
    if($Err=="")
    {
        
       $date=$_POST['Date'];
       $membersAttendance=$admin->ViewMembersAttendance($_POST['getTrainers'],$_POST['time'],$date);

    }
    /*<script>
function DisplayTable() 
{
      document.getElementById("viewAttendance").style.visibility = "block";
      
      return false;
    
}
</script>*/
    
}    

?>



<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="<?=$_SERVER['PHP_SELF'];?>"  >
            Trainer Name : <select name="getTrainers">
                <option value=""></option>
                <?php foreach ($trainers as $row){ 
                $name=$row['FirstName'].' '.$row['LastName'];
                echo "<option value=" .$row['ID'].">" .$name. "</option>";
                } ?>
                
            </select>
            
            Session Time : <select  name="time">
                
                <option value=""></option>
                <option value="8-10">8:00 to 10:00</option>
                <option value="10-12">10:00 to 12:00</option>
                <option value="12-14">12:00 to 14:00</option>
                <option value="14-16">14:00 to 16:00</option>
                <option value="16-18">16:00 to 18:00</option>
                <option value="18-20">18:00 to 20:00</option>
                <option value="20-22">20:00 to 20:00</option>
                
            </select>
            
            Date : <input type="date" id="Date" name="Date" required>
            <br><br>
            <input type="submit" name="btn"  value="Show Attendance">
            <br><br>
            <?php echo $Err;?>
            <br><br>
        
             </form> 
        
        <?php if($_SERVER['REQUEST_METHOD'] == 'POST' && $Err=="" && $membersAttendance){ ?>
        <table id="viewAttendance" name="viewAttendance"  cellpadding="8">
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
    </body>
</html>



