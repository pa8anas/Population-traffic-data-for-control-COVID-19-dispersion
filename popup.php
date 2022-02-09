<?php

include 'search.php';
// Include the database
require('config.php');
// Resume the previous session
session_start();

$userid = $_SESSION["id"];
$estimation = $_POST['estimation'];
$id = $_SESSION['point_id'];


$query = "INSERT INTO visit_declaration (userid, id, visit, estimation) VALUES ('$userid', '$id', '1', '$estimation')";
$con->query($query);
header('Location: user.php');


?>