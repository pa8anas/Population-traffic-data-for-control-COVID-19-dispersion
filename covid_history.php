<!DOCTYPE html>
<html>
<style>
table, th, td {
  border:1px solid black;
}
</style>
    <head>
    <meta charset="utf-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="style.css" rel="stylesheet" type="text/css">
        <title>History of covid-19 infections</title>
    </head>
    <body>
    <nav class="navtop">
    <div>
        <h1>CrowdScope</h1>
        <!-- Navigation Bar -->
				<a href="user.php"><i class="selected fas fa-user"></i>Dashboard</a>
				<a href="instance_declaration.php"><i class="fas fa-chart-line"></i>Instance Declaration</a>
				<a href="user_contact.php"><i class="fas fa-phone"></i>Contact User </a>
				<a href="infectedUsers.html"><i class="fas fa-bell"></i>Upload day of infection </a>
				<a href="editprofile.html"><i class="fas fa-wrench"></i>Edit Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

    </div>
</nav>

    <h2>History of covid-19 infections</h2>

        <div>

        <table  align="center" style="width: auto; color:white ">
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

$qry="SELECT userHistory.date, users.username FROM userHistory INNER JOIN users on userHistory.userid = users.userid 
/*WHERE userHistory.userid = $userid*/";
$result=mysqli_query($con,$qry);  

echo"<tableborder='1'>

<tr>

<th>Date</th>

<th>Username</th>

</tr>";

            while($row = mysqli_fetch_assoc($result)  ){

                echo "<tr>";

                echo "<td>" . $row['date'] . "</td>";

                echo "<td>" . $row['username'] . "</td>";

                echo "</tr>";

                }

            echo "</table>";

            ?>
            </table>
        </div>
    </body>
</html>








