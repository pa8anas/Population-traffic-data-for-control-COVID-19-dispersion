<?php

// Include the database
require('config.php');

// Start the session
session_start();

if(isset($_POST['submit'])){
if(!empty($_POST["date"])){

  $date = $_POST["date"];
  $userid = $_SESSION["id"];
  $infected = 1;

  $sql = "insert into infectedUsers(date, userID, infected) values ('$date', '$userid', '$infected')";
  $sql = "insert into userHistory(userid, date, infected) values ('$userid', '$date', '$infected')";

  $run = mysqli_query($con,$sql);
  if($run){

 echo "New record created successfully!";
} else {
 echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

}
}
header('Location: user.php');
 ?>
