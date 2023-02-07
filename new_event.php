<?php
include 'ConnectDatabase.php';
include 'admin_navbar.php';
if (!isset($_SESSION))
  {
    session_start();
  }
  if(isset($_POST['reg']))
  {    
    if(isset($_POST['ename'])&&isset($_POST['start'])&&isset($_POST['end'])&&isset($_POST['lat'])&&isset($_POST['long'])&&isset($_POST['capacity']))
    {
      $ename = $_POST['ename'];
      $start = $_POST['start'];
      $end = $_POST['end'];
      $lat = $_POST['lat'];
      $lon = $_POST['long'];
      $capacity = $_POST['capacity'];

        $sql_em = "select name from event_details where name='".$ename."'";
        $que_em=mysqli_query($conn,$sql_em);
        $sql_email = mysqli_num_rows($que_em);
        $check1=0;

        if($sql_email>0)
        {
          $check1=1;
          echo "<script>alert('Event Already Exists!')</script>";
        }

        if($check1==0)
        {
          //Insertion
          $sql = "INSERT INTO `event_details` (`name`,`start`,`end`,`lat`,`lon`, `capacity`, `max`) values ('$ename','$start','$end','$lat','$lon','$capacity','$capacity')";
          $query = mysqli_query($conn,$sql);
          if($query)
          {
            echo "<script>alert('Event Registerd successfully!')</script>";
            $ename = '';
            $start = '';
            $end = '';
            $lat = '';
            $lon = '';
            echo "<script>window.location.href = 'new_event.php'</script>";
          }
          else {
            echo ("Hah! Shit here we go again!". mysqli_error($conn));
          } 

      }

    }
  
  }

 
 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="create_account_style.php">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <div class="title">New Event Registration</div>
    <div class="content">
      <form action="" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Event Name</span>
            <input type="text" name="ename" placeholder="Enter event name" required>
          </div>
          <div class="input-box">
            <span class="details">Start Time</span>
            <input type="datetime-local" name="start" required>
          </div>
          <div class="input-box">
            <span class="details">End Time</span>
            <input type="datetime-local" name="end" required>
          </div>
          <div class="input-box">
            <span class="details">Latitude</span>
            <input type="text" name="lat" placeholder="Enter latitude" required>
          </div>
          <div class="input-box">
            <span class="details">Longitude</span>
            <input type="text" name="long" placeholder="Enter longitude" required>
          </div>
          <div class="input-box">
            <span class="details">Capacity</span>
            <input type="text" name="capacity" placeholder="Enter capacity" required>
          </div>

        </div>

        <div class="button">
          <input type="submit" name="reg" value="Register">
        </div>
      </form>
    </div>
  </div>

</body>
</html>