<?php
//Include the database
require('config.php');

// Start the session
session_start();

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}

$userid = $_SESSION["id"];/* userid of the user */

// check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    die ('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty and valid.
if (empty($_POST['username']) || empty($_POST['password'])) {
    // One or more values are empty.
    die ('Please complete the registration form');
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    die ('Username is not valid!');
}

$uppercase = preg_match('@[A-Z]@', $_POST['password']);
$number = preg_match('@[0-9]@', $_POST['password']);
$symbols = "!@#$%^&*()_+-=~{}[]|\?><,./:";
$symbol = strpbrk($_POST['password'], $symbols);
if (!$uppercase) { die ('Password must contain at least one uppercase letter!'); }
if (!$number) { die ('Password must contain at least one number!'); }
if (!$symbol) { die ('Password must contain at least one symbol!'); }
if (strlen($_POST['password']) < 8) { die ('Password must be at least 8 characters long!'); }

if ($stmt = $con->prepare('UPDATE users SET username = ? , password = ? WHERE userid = ?')) {
$stmt->bind_param('sss',  $_POST['username'], $_POST['password'], $userid);
$stmt->execute();
$stmt->close();
echo 'You have successfully update your data!';
header('Location: editprofile.html');
            die();
}
else {
            // Something is wrong with the sql statement, check to make sure .
            echo 'Could not prepare statement!';
        }
?>

