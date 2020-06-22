<?php

     include_once("TrainerNavigationBar.html");
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
             <h1>Choose session</h1> 
        </div>    
       <div class="container">  
        <form method="post"  >
            
            <div class="form-group">  
             <label class="col-sm-2">Session Time : </label>
             <div class="col-sm-4"> 
              <select  name="time" required="true" class="form-control">
                
                <option value=""></option>
                <option value="8-10">8:00 to 10:00</option>
                <option value="10-12">10:00 to 12:00</option>
                <option value="12-14">12:00 to 14:00</option>
                <option value="14-16">14:00 to 16:00</option>
                <option value="16-18">16:00 to 18:00</option>
                <option value="18-20">18:00 to 20:00</option>
                <option value="20-22">20:00 to 22:00</option>
                
            </select>
             </div>
         </div>
            <br><br>
            
            <input type="submit" class="btn btn-primary" name="submit" value="Show Trainees">  

            <br><br>
     </form> 
    </div>
    </body> 
</html>
