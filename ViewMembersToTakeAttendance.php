<?php

    session_start();

    if($_SESSION['id'] && $_SESSION['UserType']=='trainer'){

        
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //if button is clicked
            if(isset($_POST['submit']))
            {
                
                if( $_POST['time']!=="")
                {

                   $_SESSION['time'] = $_POST['time'];
                   header("Location:TrainerTakeAttendance.php"); 

                }else
                {
                   echo'*Please fill all fields';
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
        <form method="post"  >
            
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
            <br><br>
            
            <input type="submit" name="submit" value="Show Trainees" >
            <br><br>
             </form> 
      
    </body> 
</html>
