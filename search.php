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

$_SESSION['point_latitude'] = $latitude;
$_SESSION['point_longitude'] = $longitude;
$_SESSION['point_id'] = $id;

$stmt2 = $con->prepare('SELECT AVG(estimation) AS average FROM visit_declaration WHERE id = ? AND `timestamp` BETWEEN DATE_SUB(NOW(), INTERVAL 2 HOUR) AND NOW()');

// Bind the parameters and execute the query
$stmt2->bind_param('s', $id);
$stmt2->execute();
$stmt2->store_result();
$stmt2->bind_result($average);
$stmt2->fetch();
$stmt2->close();

if (is_null($average)) {
    $average = 0;
    }

      $stmt3 = $con->prepare('SELECT COUNT(*) AS poi_visitors FROM visit_declaration WHERE id = ? AND `timestamp` BETWEEN DATE_SUB(NOW(), INTERVAL 2 HOUR) AND NOW()');
       // Bind the parameters and execute the query
      $stmt3->bind_param('s', $id);
      $stmt3->execute();
      $stmt3->store_result();
      $stmt3->bind_result($poi_visitors);
      $stmt3->fetch();
      $stmt3->close();

      $stmt4 = $con->prepare('SELECT COUNT(*) AS users FROM users WHERE type = 1');
      // Bind the parameters and execute the query
      //$stmt4->bind_param('s', $id);
      $stmt4->execute();
      $stmt4->store_result();
      $stmt4->bind_result($users);
      $stmt4->fetch();
      $stmt4->close();

      $visit_estimation = ($poi_visitors/$users)*100;
       if (is_null($poi_visitors)) {
              $visit_estimation = 0;
            }
        $_SESSION['visit_estimation'] = $visit_estimation;
        $_SESSION['average'] = $average;
      header('Location: user.php');
       }
       else {
                echo "<h2>No exists this point of interests!</h2>";
     			header('Location: user.php');
     		}

}
?>

