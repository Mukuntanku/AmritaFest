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
  $filtervalues=$_POST['searchQueryInput'];

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
  <h1>Search results for <em>"<?php echo $filtervalues?>"</em></h1><br>
  <form action="#modal" method="GET">
     <!-- <div class="input-group mb-3">
         <input type="text" name="search" required value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>" class="form-control" placeholder="Search data">
         <button type="submit" class="btn btn-primary">Search</button>
     </div> -->
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
        $query = "SELECT name, start, end, lat, lon, capacity FROM event_details WHERE name LIKE '%$filtervalues%';";
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
</body>
</html>
