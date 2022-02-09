<?php
// Include the database
require_once('config.php');

// Resume the previous session
session_start();

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
if (isset($_POST["date"])){

  $date = $_POST["date"];
  $userid = $_SESSION["id"];
  $infected = 1;

  $sql = "insert into infectedusers(date, userID, infected) values ('$date', '$userid', '$infected')";
  $sql1 = "insert into userhistory(userid, date, infected) values ('$userid', '$date', '$infected')";

  $run = mysqli_query($con,$sql);
  $run = mysqli_query($con,$sql1);
  if($run){


 echo "<h2>" "New record created successfully!" "</h2>";
} else {
 echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

header('Location: instance_declaration.html');
}
else {  die ('Please complete the date!');  }
 ?>