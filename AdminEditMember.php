<?php



    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='admin')
    {

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


        $sessions=$admin->GetAvailableSessions($packageNo);

        if($sessions==-1)
        {
            echo "<script>alert('Member is not enrolling in a package so nothing to edit');
                 window.location.href='ViewMembers.php';
                  </script>";

        }


        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            
           if(isset($_POST['submit']))
           {
               $admin->EditMember($ID,$_POST['SessionsTime']);
               header("Location:ViewMembers.php");
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
    Sessions Time : 
       <br><br>
       <?php    $rows = count($sessions);
                for($row=0;$row<$rows;$row++) 
                {  ?>
      
                   <input type="radio"  name="SessionsTime"  value="<?php echo $sessions[$row][1].'/'.$sessions[$row][2]; ?>" ><?php echo $sessions[$row][2].':00 '.$sessions[$row][3].':00 ('.$sessions[$row][0].')'; ?>
                   <br><br>
       <?php    } ?>
                
                
           
  <br><br>
  
  <input type="submit" name="submit" value="Submit" >  
</form>
        
    </body>
</html>










