<?php

// Resume the previous session
session_start();

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>User Dashboard</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
                crossorigin="" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>CrowdScope</h1>

				<!-- Navigation Bar -->
				<a href="user.php"><i class="selected fas fa-user"></i>Dashboard</a>
				<a href="instance_declaration.php"><i class="fas fa-chart-line"></i>Instance Declaration</a>
				<a href="user_contact.php"><i class="fas fa-chart-line"></i>Instance Declaration</a>
				<a href="editprofile.html"><i class="fas fa-chart-line"></i>Edit Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>User Dashboard</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>

		    <p>Search a point of interest around you.</p>

            <div id="search"></div>
            <form action="search.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Point of interest" id="name" required>
            <input type="submit" name="submit" value="Submit">
            </form>

            <div id="map" style="height: 510px; width:100%"></div>
                <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                    crossorigin=""></script>
                <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
                <script language="JavaScript" type="text/javascript" src="/js/jquery-1.2.6.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="/js/jquery-ui-personalized-1.5.2.packed.js"></script>
                <script language="JavaScript" type="text/javascript" src="/js/sprinkle.js"></script>
                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

                <!-- Load The Map  -->
                <script src="map.js"></script>


		</div>
    </body>
</html>
