<?php
include 'ConnectDatabase.php';
include 'reg_user_navbar.php';
if (!isset($_SESSION))
  {
    session_start();
  }

  $query0 = "SELECT name, start, end, lat, lon, capacity, max FROM event_details";
  $query_run0 = mysqli_query($conn, $query0);
  $locations = array();
  while ($location = mysqli_fetch_assoc($query_run0)) {
    $locations[] = $location;
  }


?>

<!DOCTYPE html>
<html>
<head>
  <style>
    #sidebar {
      width: 78;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #f2f2f2;
      padding: 20px;
    }
    #map {
      width: calc(100% - 78px);
      height: 100%;
      position: absolute;
      top: 0;
      right: 0;
    }
  </style>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
     integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
     crossorigin=""/>

  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
     integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
     crossorigin=""></script>
</head>
<body>

  <div id="map"></div>

  <script>
    var map = L.map('map').setView([11.6643, 78.1460], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    <?php foreach ($locations as $location): ?>
      var marker = L.marker([<?php echo $location['lat']; ?>, <?php echo $location['lon']; ?>])
        .bindPopup("<h2>Event Details</h2><b>Name:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['name']; ?><br><b>Start:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['start']; ?><br><b>End:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['end']; ?><br><b>Current Capacity:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['capacity']; ?><br><b>Max Capacity:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['max']; ?><br><b>Latitude:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['lat']; ?><br><b>Longitude:</b>&nbsp;&nbsp;&nbsp;<?php echo $location['lon']; ?>")
        .addTo(map);
    <?php endforeach; ?>
  </script>
</body>
</html>
