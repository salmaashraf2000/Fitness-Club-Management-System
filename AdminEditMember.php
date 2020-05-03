<?php

require_once 'Admin.php';
require_once 'Validation.php';

$admin=new Admin();

$SessionErr=""; 
$msg="";
$ID= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$packageNo=filter_input(INPUT_GET,'packageNo',FILTER_SANITIZE_NUMBER_INT);
$trainerID=filter_input(INPUT_GET,'trainerID',FILTER_SANITIZE_NUMBER_INT);
$SessionStartTime=filter_input(INPUT_GET,'SessionStartTime',FILTER_SANITIZE_NUMBER_INT);
$SessionEndTime=filter_input(INPUT_GET,'SessionEndTime',FILTER_SANITIZE_NUMBER_INT);
$admin=new Admin();


$sessions=$admin->GetAvailableSessions(/*$packageNo*/1);
/*$rows = count($sessions);
for($row=0;$row<$rows;$row++) 
{
                  
   echo  $sessions[$row][0]." ".$sessions[$row][1]." ".$sessions[$row][2]."<br>";
}                    
/*foreach ( $sessions as $Session ) {

  foreach ( $Session as $key => $value ) {
      
    echo $value." ";
  }

  echo "<br>";
}*/




if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo 'ffggh '.$_POST['SessionsTime'];
   if(isset($_POST['submit']))
   {
       $admin->EditMember($ID,$_POST['SessionsTime']);
       header("Location:ViewMembers.php");
   }

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
    Sessions Time : 
       <br><br>
       <?php    $rows = count($sessions);
                for($row=0;$row<$rows;$row++) 
                {  ?>
      
                   <input type="radio"  name="SessionsTime[]"  value="<?php echo $sessions[$row][1].'/'.$sessions[$row][2]; ?>" <?php if($trainerID==$sessions[$row][1] && $SessionStartTime==$sessions[$row][2]){ echo"checked";} ?> ><?php echo $sessions[$row][2].':00 '.$sessions[$row][3].':00 ('.$sessions[$row][0].')'; ?>
                   <br><br>
       <?php    } ?>
                
                
           
  <br><br>
  
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>










