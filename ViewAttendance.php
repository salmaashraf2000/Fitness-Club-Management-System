<?php

require 'Admin.php';
$membersAttendance="";
$Err="";
        
function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
  $admin= new Admin();
  $trainers =$admin->GetTrainers();
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo 'giiiii';
    echo $_POST['getTrainers']." ".$_POST['time']." ",$_POST['Date'];
   /* if($_POST['trainers'] == '' || $_POST['time'] || $_POST['Date']){
        $Err='*All fields must be selected';
    } else {*/
        $membersAttendance=$admin->ViewMembersAttendance($_POST['getTrainers'],$_POST['time'],$_POST['Date']);
   // }
    
    
}    
/*<script>
function DisplayTable() 
{
  if(!$error_fields)
  {
      document.getElementById("myP1").style.display = "none";
    <?php   $admin= new Admin();
     $membersAttendance=$admin->ViewMembersAttendance(); ?>
  }else
  {
    <?php echo 'NO Results'; ?>
  }    
  
}
 * 
 * 
 * <option value="<?php $row['ID']?>"><?php $row['FirstName'].' '.$row['LastName']?></option>
</script>*/
?>

<script>
function DisplayTable() 
{
      document.getElementById("viewAttendance").style.display = "block";
    
}
</script>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form>
            Trainer Name : <select id="trainers" name="getTrainers">
                <option value=""></option>
                <?php foreach ($trainers as $row){ 
                $name=$row['FirstName'].' '.$row['LastName'];
                echo "<option value=" .$row['ID'].">" .$name. "</option>";
                } ?>
                
            </select>
            
            Session Time : <select id="Time" name="time">
                
                <option value=""></option>
                <option value="8-10">8 to 10</option>
                <option value="10-12">10 to 12</option>
                <option value="12-2">12 to 2</option>
                <option value="2-4">2 to 4</option>
                <option value="4-6">4 to 6</option>
                <option value="6-8">6 to 8</option>
                <option value="8-10">8 to 10</option>
                
            </select>
            
            Date : <input type="date" id="Date" name="Date">
            <br><br>
            <input type="button" onclick="DisplayTable()" value="Show Attendance">
            <br><br>
            <?php echo $Err;?>
        </form>
        
        
        
        <table id="viewAttendance"  style="display: none" cellpadding="8">
            <thread>
                <tr>
                    <th>Member Name</th>
                    <th>Attendance</th>
             
                </tr>
            </thread>   
            <?php   foreach ($membersAttendance as $Row){ ?>
                <tr>
                    <td><?= $Row['FirstName'].' '.$Row['LastName']?></td>
                    <td><?= $Row['Attendance']?></td>
                   
                </tr>    
            <?php } ?>     
        </table>
        
    </body>
</html>



