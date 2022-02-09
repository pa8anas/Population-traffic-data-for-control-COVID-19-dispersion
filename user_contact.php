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
    <title>Contact Tracing</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">
<nav class="navtop">
    <div>
        <h1>Covid-19 Tracing</h1>

        <!-- Navigation Bar -->
       <a href="user.php"><i class="fas fa-search"></i>Pois Search</a>
       <a href="instance_declaration.html"><i class="fas fa-diagnoses"></i>Case Declaration</a>
       <a href="user_contact.php"><i class="selected fas fa-notes-medical"></i>Contact tracing</a>
       <a href="editprofile.html"><i class="fas fa-edit"></i>Edit Profile</a>
       <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>
<div class="content">
<div>
<table align="center" border="1px solid powderblue" padding="30px" style="width:1150px;line-height:40px;">
      <tr>
        <th colspan="3"><h2>You got in touch with Covid-19 cases in below pois and times</h2></th>
        </tr>
         <th>name</th>
         <th>address</th>
         <th>date & time</th>
      <?php
$userid = $_SESSION["id"];

$query = $con->prepare("CREATE TABLE instances_visits AS select id,timestamp  from visit_declaration as t1 inner join infectedusers t2 on t1.userid = t2.userID where t2.date BETWEEN DATE(t1.timestamp) AND ADDDATE(DATE(t1.timestamp), INTERVAL 7 DAY)");
$query->execute();
$query->close();

$query2 = $con->prepare("CREATE TABLE user_visits AS select id,timestamp from visit_declaration where userid = ?");
$query2->bind_param('s', $userid);
$query2->execute();

$query3 = "SELECT user_visits.id,user_visits.timestamp FROM user_visits INNER JOIN instances_visits ON user_visits.id = instances_visits.id WHERE DATE(user_visits.timestamp) = DATE(instances_visits.timestamp) AND user_visits.timestamp BETWEEN DATE_SUB(instances_visits.timestamp, INTERVAL 2 HOUR ) AND ADDDATE(instances_visits.timestamp, INTERVAL 2 HOUR);";
$result = $con->query($query3);
      if ($result->num_rows > 0) {
                 // output data of each row
          while($row = $result->fetch_assoc()) {

          // Create select query to get ids of pois from data table
          $query4 = $con->prepare("SELECT name,address FROM data WHERE id = ?");
          // Bind the parameters and execute the query
          $query4->bind_param('s', $row["id"]);
          $query4->execute();
          $query4->store_result();
          $query4->bind_result($name, $address);
          $query4->fetch();
          $query4->close();

          ?>
          <tr>
                    <td><?php echo $name;?></td>
                    <td><?php echo $address;?></td>
                    <td><?php echo $row['timestamp'];?></td>
                  </tr>
            <?php
            }
            }
            $query5 = $con->prepare("DROP TABLE instances_visits");
            $query5->execute();
            $query5->close();

            $query6 = $con->prepare("DROP TABLE user_visits");
            $query6->execute();
            $query6->close();

      ?>
    </table>

</div>
</div>
</body>
</html>