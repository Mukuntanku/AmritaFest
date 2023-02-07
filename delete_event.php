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

  if(isset($_GET['action'])){
    if ($_GET['action'] == "delete") {
        $cid = $_GET['id'];
        $cid1 = $_GET['id1'];

        $sql = "DELETE FROM registered_events WHERE code = $cid;";
        $result = mysqli_query($conn, $sql);        

        $sql1 = "UPDATE event_details SET capacity = capacity + 1 WHERE name = '".$cid1."';";
        $result1 = mysqli_query($conn, $sql1);

        if($result && $result1){
            echo '<script>alert("Event De-Registered Successfully!")</script>';
        }
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
  <h1>Registered Events</h1><br>
  <table>
    <thead>
      <tr>
        <th>Event</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Code</th>
        <th>De-Register Event</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $query = "SELECT uname, ename, start, end, code FROM registered_events where uname = '".$email."';";
        $query_run = mysqli_query($conn, $query);

        if(mysqli_num_rows($query_run) > 0)
        {
            foreach($query_run as $items)
            {
                ?>
                <tr>
                    <td><?= $items['ename']; ?></td>
                    <td><?= $items['start']; ?></td>
                    <td><?= $items['end']; ?></td>
                    <td><?= $items['code']; ?></td>
                    <td>
                        <span>
                        <a href="delete_event.php?action=delete&id=<?= $items['code']; ?>&id1=<?= $items['ename']; ?>" class="deletebutton">De-Register</a>
                        </span>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
                <tr>
                    <td colspan="5">Currently No Events Registered!!</td>
                </tr>
            <?php
        }
?>
    </tbody>
  </table>
</body>
</html>
