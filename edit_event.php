<?php
include 'ConnectDatabase.php';
include 'admin_navbar.php';
if (!isset($_SESSION))
  {
    session_start();
  }

if(isset($_GET['search'])){
        $id=$_GET['search'];
        $query0 = "SELECT name, start, end, lat, lon, max FROM event_details where name = '".$id."';";
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
                $capacity = $items0['max'];

                $name_ref = $items0['name'];
                $start_ref = $items0['start'];
                $end_ref = $items0['end'];
                $lat_ref = $items0['lat'];
                $lon_ref = $items0['lon'];
                $capacity_ref = $items0['max'];
            }
        }
        else{
          echo "<script>alert('No Event found with the name')</script>";
          echo "<script>window.location.href = 'edit_event.php'</script>";
        }
}

if(isset($_POST['editacc']))
  {
    if(isset($_POST['ename'])&&isset($_POST['start'])&&isset($_POST['end'])&&isset($_POST['lat'])&&isset($_POST['lon'])&&isset($_POST['capacity']))
    {
      $name = $_POST['ename'];
      $start = $_POST['start'];
      $end = $_POST['end'];
      $lat = $_POST['lat'];
      $lon = $_POST['lon'];
      $capacity = $_POST['capacity'];

        $sql_em = "select name from event_details where name='".$name."'";
        $que_em=mysqli_query($conn,$sql_em);
        $sql_email_value=mysqli_fetch_array($que_em);
        $sql_email = mysqli_num_rows($que_em);
        $check1=0;

        if($sql_email>0 && $name_ref!=$name)
        {
          $check1=1;
          echo "<script>alert('Failed! Event already exists in that name!')</script>";
                $name = $name_ref;
                $start = $start_ref;
                $end = $end_ref;
                $lat = $lat_ref;
                $lon = $lon_ref;
                $capacity = $capacity_ref;
        }
        if($check1==0)
        {
          //Insertion
          $sql = "UPDATE `event_details` SET name='$name',start='$start',end='$end',lat='$lat',lon='$lon',max='$capacity' where name = '".$id."'";
          $query = mysqli_query($conn,$sql);
          if($query)
          {
           
            echo "<script>alert('Details Edited Successfully!')</script>";
            echo "<script>window.location.href = 'edit_event.php'</script>";
          }
          else {
            echo("Error description: " . mysqli_error($conn));
            echo "<script>window.location.href = 'edit_event.php'</script>";
          }
        }

      }
      
  }

if(isset($_POST['delete'])){
  $sql = "DELETE FROM event_details WHERE name = '".$id."'";

  if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Event deleted successfully!')</script>";
    echo "<script>window.location.href = 'edit_event.php'</script>";
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
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
  <h1>Modify Event Details</h1><br>
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
        $query = "SELECT name, start, end, lat, lon, max FROM event_details;";
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
                    <td><?= $items['max']; ?></td>
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
        <h2 class="modal__heading">Edit or Delete Event</h2>
          <div class="container">
            <div class="content">
              <form action="" method="post">
                <div class="user-details">
                  <div class="input-box">
                    <span class="details">Event Name</span>
                    <input type="text" name="ename" required value="<?php echo $name; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Start Time</span>
                    <input type="datetime-local" name="start" required value="<?php echo $start; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">End Time</span>
                    <input type="datetime-local" name="end" required value="<?php echo $end; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Latitude</span>
                    <input type="text" name="lat"required value="<?php echo $lat; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Longitude</span>
                    <input type="text" name="lon" required value="<?php echo $lon; ?>">
                  </div>
                  <div class="input-box">
                    <span class="details">Capacity</span>
                    <input type="text" name="capacity" required value="<?php echo $capacity; ?>">
                  </div>

                </div>
                <form class="" action="" method="post">
                    <div class="button">
                      <input type="submit" name="editacc" value="Edit Event">
                    </div>
                    <div class="button">
                        <input type="submit" name="delete" value="Delete Event">
                    </div>
                </form>
              </form>
            </div>
          </div>
      </div>
    </div>
</body>
</html>
