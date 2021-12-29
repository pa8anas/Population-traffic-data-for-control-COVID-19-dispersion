<?php

// Include the database
require('config.php');
// Resume the previous session
session_start();

// Prepare the SQL statement
if ($stmt = $con->prepare('SELECT id,latitude, longitude FROM data WHERE name = ?')) {

      // Bind the parameters and execute the query
      $stmt->bind_param('s', $_POST['name']);
      $stmt->execute();
      $stmt->store_result();

      // Check if the name exists in the database
      if ($stmt->num_rows > 0) {

      // Load the 'latitude', 'longitude' of the location
      $stmt->bind_result($id, $latitude, $longitude);
      $stmt->fetch();
      // Terminate the SQL statement
      $stmt->close();

      $_SESSION['point_id'] = $id;
      $lat_name = "latitude";
      $long_name = "longitude";
      setcookie($lat_name, $latitude);
      setcookie($long_name, $longitude);

      header('Location: user.php');
       }
       else {
                echo "<h2>No exists this point of interests!</h2>";
     			header('Location: user.php');
     		}

}
?>

