<?php
include 'ConnectDatabase.php';
include 'reg_user_navbar.php';
if (!isset($_SESSION))
  {
    session_start();
  }

  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $email = $_SESSION['email'];

if(isset($_GET['search'])){
        $id=$_GET['search'];
        $query0 = "SELECT name, start, end, lat, lon, capacity FROM event_details where name = '".$id."';";
        $query_run0 = mysqli_query($conn, $query0);

        if(mysqli_num_rows($query_run0) > 0)
        {
            foreach($query_run0 as $items0)
            {
                $name = $items0['name'];
                $start = $items0['start'];
                $end = $items0['end'];
                $lat = $items0['lat'];
                $lon = $items0['lon'];
                $capacity = $items0['capacity'];
            }
        }
        else{
          echo "<script>alert('No Event found with the name')</script>";
          echo "<script>window.location.href = 'edit_event.php'</script>";
        }
}

if(isset($_POST['editacc']))
{
  $tst = 1;
  $query1 = "SELECT uname, ename, start, end FROM registered_events where uname = '".$email."';";
  $query_run1 = mysqli_query($conn, $query1);

  if(mysqli_num_rows($query_run1) > 0)
        {
          foreach($query_run1 as $items1)
            {
                $ename1 = $items1['ename'];
                if($ename1 == $name){
                  $tst = 0;
                  break;
                }
            }
        }
  if($tst == 1){
        $tst1 = 1;
        $query2 = "SELECT uname, ename, start, end FROM registered_events where uname = '".$email."';";
        $query_run2 = mysqli_query($conn, $query2);

        if(mysqli_num_rows($query_run2) > 0)    {
            foreach($query_run2 as $items2)
            {
                $start1 = $items2['start'];
                $end1 = $items2['end'];

                if ($end1 > $start && $start1 < $end) {
                  $tst1 = 0;
                  break;
                }
            }
        }


        if($tst1 == 1){
          if($capacity > 0){

            $tst2 = 1;
            while($tst2){
                $code = rand(1000,9999);
                $query2 = "SELECT * FROM registered_events where code = $code;";
                $query_run2 = mysqli_query($conn, $query2);  
                
                if(mysqli_num_rows($query_run2) == 0){
                    $tst2 = 0;
                }
            }
            
            $query2 = "INSERT INTO `registered_events` (`uname`,`ename`,`start`,`end`,`code`,`status`) values ('$email','$name','$start','$end','$code','out')";
            $query_run2 = mysqli_query($conn, $query2);
            $new_capacity = $capacity-1;
            $query2 = "UPDATE `event_details` SET capacity='$new_capacity' where name = '".$id."'";
            $query_run2 = mysqli_query($conn, $query2);
            if($query_run2){
              echo "<script>alert('Event Registered Successfully')</script>";
              echo "<script>window.location.href = 'reg_event.php'</script>";
            }   
          }
          else{
            echo "<script>alert('Event @Full Capacity')</script>";
            echo "<script>window.location.href = 'reg_event.php'</script>";      
          }
        }
        else{
          echo "<script>alert('Event Overlaps')</script>";
          echo "<script>window.location.href = 'reg_event.php'</script>";               
        }
  }
  else{
    echo "<script>alert('Event Already Registered')</script>";
    echo "<script>window.location.href = 'reg_event.php'</script>";     
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Mukta:wght@300;400;600;700;800&family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="admin_renewal_track.css">
  <link rel="stylesheet" href="admin_edit_user_style.php">
  <style>
      /*Modal*/
    .modal{
       background-color: rgba(0,0,0, .8);
       width:100%;
       height: 100vh;
       position: absolute;
       top: 0;
       left: 0;
       z-index: 10;
       opacity: 0;
       visibility: hidden;
       transition: all .5s;
      }

      .modal__content{
       width: 50%;
       height: 90%;
       background-color: #fff;
       position: absolute;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
       padding: 2em;
       border-radius: 1em;
       opacity: 0;
       visibility: hidden;
       transition: all .5s;
      }

      #modal:target{
       opacity: 1;
       visibility: visible;
      }

      #modal:target .modal__content{
       opacity: 1;
       visibility: visible;
      }

      .modal__close{
       color: #363636;
       font-size: 2em;
       position: absolute;
       top: .5em;
       right: 1em;
      }

      .modal__heading{
       color: dodgerblue;
       margin-bottom: 1em;
      }

      .modal__paragraph{
       line-height: 1.5em;
      }

    .modal-open{
     display: inline-block;
     color: dodgerblue;
     margin: 2em;
    }
  </style>

</head>

<body>
  <h1>Event list</h1><br>
  <form action="#modal" method="GET">
     <div class="input-group mb-3">
         <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
         <button type="submit" class="btn btn-primary">Search</button>
     </div>
 </form>
  <table>
    <thead>
      <tr>
        <th>Event</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Capacity</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT name, start, end, lat, lon, capacity FROM event_details;";
        $query_run = mysqli_query($conn, $query);

        if(mysqli_num_rows($query_run) > 0)
        {
            foreach($query_run as $items)
            {
                ?>
                <tr>
                    <td><?= $items['name']; ?></td>
                    <td><?= $items['start']; ?></td>
                    <td><?= $items['end']; ?></td>
                    <td><?= $items['lat']; ?></td>
                    <td><?= $items['lon']; ?></td>
                    <td><?= $items['capacity']; ?></td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
                <tr>
                    <td colspan="6">No Record Found</td>
                </tr>
            <?php
        }
?>
    </tbody>
  </table>

    <div class="modal" id="modal">
      <div class="modal__content">
        <a href="#" class="modal__close">&times;</a>
        <h2 class="modal__heading">Event Registeration</h2>
          <div class="container">
            <div class="content">
              <form action="" method="post">
                <div class="user-details">
                  <div class="input-box">
                    <span class="details">Event Name</span>
                    <input type="text" name="ename" readonly value="<?php echo $name; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Start Time</span>
                    <input type="datetime-local" name="start" readonly value="<?php echo $start; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">End Time</span>
                    <input type="datetime-local" name="end" readonly value="<?php echo $end; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Latitude</span>
                    <input type="text" name="lat" readonly value="<?php echo $lat; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Longitude</span>
                    <input type="text" name="lon" readonly value="<?php echo $lon; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Capacity</span>
                    <input type="text" name="capacity" readonly value="<?php echo $capacity; ?>">
                  </div>

                </div>
                <form class="" action="" method="post">
                    <div class="button">
                      <input type="submit" name="editacc" value="Register">
                    </div>
                </form>
              </form>
            </div>
          </div>
      </div>
    </div>
</body>
</html>
