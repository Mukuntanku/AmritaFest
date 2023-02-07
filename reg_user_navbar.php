<?php
if (!isset($_SESSION))
{
  session_start();
}
include 'ConnectDatabase.php';
$whoishe='reg_user';
if($whoishe=='reg_user')
{
    if($_SESSION['lname'])
    {
      // Storing for displaying in bottom of navbar details
     $fname = $_SESSION['fname'];
     $lname = $_SESSION['lname'];
     $email = $_SESSION['email'];
    }
}

?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="reg_user_navbar_style.php">
    <script src="https://kit.fontawesome.com/afc6005920.js" crossorigin="anonymous"></script> <!-- to get desired icons link to font awesome-->
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx bxl-c-plus-plus icon'></i> -->
      <i class="fas fa-graduation-cap icon"></i>
        <div class="logo_name">A M R I T A</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">

      <li>
        <a href="Home_page.php">
          <i class="fas fa-house-damage"></i>
          <span class="links_name">Home</span>
        </a>
         <span class="tooltip">Home</span>
      </li>
      <?Php
      if($whoishe=='reg_user')
      {
        echo "      <li>";
        echo "       <a href='reg_user_profile.php'>";
        echo "         <i class='fas fa-user-alt'></i>";
        echo "         <span class='links_name'>Profile</span>";
        echo "       </a>";
        echo "       <span class='tooltip'>Profile</span>";
        echo "      </li>";
        echo "     <li>";
        echo "       <a href='reg_event.php'>";
        echo "         <i class='fas fa-images'></i>";
        echo "         <span class='links_name'>Events</span>";
        echo "       </a>";
        echo "       <span class='tooltip'>Events</span>";
        echo "     </li>";
      }
      ?>
      <li>
       <a href="delete_event.php">
       <i class="fas fa-chart-line"></i>
         <span class="links_name">Registered Events</span>
       </a>
       <span class="tooltip">Registered Events</span>
     </li>
      <li>
       <a href="map.php">
       <i class="fas fa-calendar-week"></i>
         <span class="links_name">Map View</span>
       </a>
       <span class="tooltip">Map View</span>
     </li>
     <li>
       <a href="logout.php" onclick="return confirm('Are you sure to logout')">
       <i class="fas fa-sign-out-alt"></i>
         <span class="links_name">Log out</span>
       </a>
       <span class="tooltip">Log out</span>
     </li>


     <li class="profile">
         <div class="profile-details">
           <!--<img src="profile.jpg" alt="profileImg">-->
           <div class="name_job">
           <?php

           if($_SESSION['lname'])
           {
            $name = $_SESSION['fname'];
             echo "<div class='name'> $name  </div>";
             if($whoishe=='reg_user')
             {
              echo "<div class='job'>REGISTERED USER</div>";
             }
             else{
              echo "<div class='job'>UNREGISTERED USER</div>";
             }


           }

           ?>

           </div>
         </div>
         <i class='bx bx-log-out' id="log_out" ></i>
     </li>
    </ul>
  </div>

  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
   }
  }
  </script>
</body>
</html>
