
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="reg_user_profile.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <?php include 'reg_user_navbar.php';?>
  <div class="card-container">
  	<span class="pro">Registered user</span>

<br><br>
<?php 
         include 'ConnectDatabase.php';
         // session_start();
         $reg_id = $_SESSION['id'];
           if($_SESSION['lname'])
           {
            $fname = $_SESSION['fname'];
            $lname = $_SESSION['lname'];
            $email = $_SESSION['email'];
            echo "<span> NAME         :  <span>";
             echo "<span> $fname <span>";
             echo "<span> $lname <span>";
             echo "<br>";
             echo "<br>";
             echo "<span> EMAIL        :  <span>";
             echo "<div class='job'>$email</div>";
             echo "<br>";
           } 
           
           ?>
    <br><br>
  
  </div>

</body>
</html>
