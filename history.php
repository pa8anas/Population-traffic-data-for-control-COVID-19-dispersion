<?php

// Resume the previous session
session_start();

 // Include the database
    require('config.php');

 //If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
   header('Location: index.html');
    exit();
}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">



<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Covid-19 Tracing</h1>
        <!-- Navigation Bar -->
        <a href="user.php"><i class="fas fa-search"></i>Pois Search</a>
        <a href="instance_declaration.html"><i class="fas fa-diagnoses"></i>Case Declaration</a>
        <a href="user_contact.php"><i class="fas fa-notes-medical"></i>Contact tracing</a>
        <a href="editprofile.html"><i class="fas fa-edit"></i>Edit Profile</a>
        <a href="history.php"><i class="selected fas fa-history"></i>History</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

    </div>
</nav>

<div class="content">
    <h1>History</h1>
    <h2>You can see your visit history and when you were covid-19 case</h2>

    <div>
        <table align="center" border="1px solid powderblue" padding="30px" style="width:1150px;line-height:40px;">
            <tr>
                <th colspan="3"><h2>You visited below pois at below times</h2></th>
            </tr>
            <th>name</th>
            <th>address</th>
            <th>date & time</th>

      <?php
$userid = $_SESSION["id"];

$query = $con->prepare("SELECT id,timestamp FROM visit_declaration WHERE userid = ?");
 $query->bind_param('s', $userid);
 $query->execute();
    $result = $query->get_result();

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {

// Create select query to get name of pois from data table
$query2 = $con->prepare("SELECT name,address FROM data WHERE id = ?");
// Bind the parameters and execute the query
$query2->bind_param('s', $row["id"]);
$query2->execute();
$query2->store_result();
$query2->bind_result($name, $address);
$query2->fetch();
$query2->close();

?>
            <tr>
                <td><?php echo $name;?></td>
                <td><?php echo $address;?></td>
                <td><?php echo $row['timestamp'];?></td>
            </tr>
            <?php
            }
            }

            ?>
        </table>

    </div>

    <div>
            <table align="center" border="1px solid powderblue" padding="30px" style="width:1150px;line-height:40px;">
                <tr>
                    <th colspan="3"><h2>You were covid-19 case at below date</h2></th>
                </tr>
                <th>date</th>
          <?php
    $userid = $_SESSION["id"];

    $query3 = $con->prepare("SELECT date FROM userhistory WHERE userid = ?");
     $query3->bind_param('s', $userid);
     $query3->execute();
        $result2 = $query3->get_result();

    if ($result2->num_rows > 0) {
    // output data of each row
    while($row2 = $result2->fetch_assoc()) {



    ?>
                <tr>
                    <td><?php echo $row2['date'];?></td>
                </tr>
                <?php
                }
                }

                ?>
            </table>

        </div>

</div>
</body>
</html>