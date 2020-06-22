<?php


    include_once("AdminNavigationBar.html");
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
             <h1>Edit Member Session</h1> 
    </div>    
    <div class="container">       
     <form method="post">  
                
         <div class="form-check">  
             <label class="col-sm-2">Sessions Time : </label>
             <div class="col-sm-4"> 
              
                <?php    $rows = count($sessions);
                for($row=0;$row<$rows;$row++) 
                {  ?>
                   <input type="radio"  name="SessionsTime" required="true" value="<?php echo $sessions[$row][1].'/'.$sessions[$row][2]; ?>" <?php if($trainerID==$sessions[$row][1] && $SessionStartTime==$sessions[$row][2]){ echo"checked";} ?> ><?php echo $sessions[$row][2].':00 '.$sessions[$row][3].':00 ('.$sessions[$row][0].')'; ?>
                   <br><br>
       <?php    } ?>   
             </div>
         </div>
         <br><br>       
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">  
  
   
    </form>
    </div>      
    </body>
</html>










