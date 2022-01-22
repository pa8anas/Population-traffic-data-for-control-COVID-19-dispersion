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

  $sql = "insert into infectedUsers(date, userid, infected) values ('$date', '$userid', '$infected')";
  $sql1 = "insert into userHistory(userid, date, infected) values ('$userid', '$date', '$infected')";

  $run = mysqli_query($con,$sql);
  $run = mysqli_query($con,$sql1);
  if($run){

 echo "New record created successfully!";
} else {
 echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

}
}
header('Location: user.php');
 ?>
