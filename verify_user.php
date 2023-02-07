<?php
include 'ConnectDatabase.php';
include 'admin_navbar.php';
if (!isset($_SESSION))
  {
    session_start();
  }

if(isset($_POST['reg']))
  {    
    if(isset($_POST['code']))
    {
      $code = $_POST['code'];

        $sql_em = "select * from registered_events where code = $code;";
        $que_em=mysqli_query($conn,$sql_em);
        $sql_email = mysqli_num_rows($que_em);
        $check1=0;

        if($sql_email == 0)
        {
          $check1=1;
          echo "<script>alert('Event Code Dosent Exist!')</script>";
        }

        if($check1==0)
        {
            foreach($que_em as $items2)
            {
                $ename = $items2['ename'];
                $uname = $items2['uname'];
                $status = $items2['status'];
                if ($status == "in") {
                    echo "<script>alert('Code Already Verified!')</script>";
                  break;
                }
                else{
                    $query2 = "UPDATE `registered_events` SET status = 'in' where code = $code;";
                    $query_run2 = mysqli_query($conn, $query2);
                    if($query_run2){
                      echo "<script>alert('Event Name: $ename          User mail: $uname');</script>";
                      echo "<script>alert('Code Successfully Verified');</script>";
                      echo "<script>window.location.href = 'verify_user.php'</script>";
                    }
                }
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
    <div class="title">Enter Unique Code</div>
    <div class="content">
      <form action="" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Code</span>
            <input type="text" name="code" placeholder="Enter event name" required>
          </div>
        </div>

        <div class="button">
          <input type="submit" name="reg" value="Verify">
        </div>
      </form>
    </div>
  </div>

</body>
</html>