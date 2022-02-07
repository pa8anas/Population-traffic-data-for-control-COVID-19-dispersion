<?php

// Resume the previous session
session_start();

// Include the database
require('config.php');

// If the user is not logged in redirect to the login page
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit();
}

//$latitude = $_SESSION['point_latitude'];
//$longitude = $_SESSION['point_longitude'];
//$visit_estimation = $_SESSION['visit_estimation'];
//$average = $_SESSION['average'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>User Dashboard</title>
		<link href="style_.css" rel="stylesheet" type="text/css">
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
				<a href="user_contact.php"><i class="fas fa-phone"></i>Contact User </a>
				<a href="infectedUsers.html"><i class="fas fa-hotdog"></i> Report Infection</a>
				<a href="editprofile.html"><i class="fas fa-wrench"></i>Edit Profile</a>
				<a href="covid_history.php"><i class="fas fa-book"></i>History of infections</a>
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

<?php
$latitude = $_SESSION['point_latitude'];
$longitude = $_SESSION['point_longitude'];
$visit_estimation = $_SESSION['visit_estimation'];
$average = $_SESSION['average'];
?>
                <!-- Load The Map  -->
<script>
var map_init = L.map('map', {
    center: [9.0820, 8.6753],
    zoom: 8
});
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map_init);
L.Control.geocoder().addTo(map_init);
if (!navigator.geolocation) {
    console.log("Your browser doesn't support geolocation feature!")
} else {
    setInterval(() => {
        navigator.geolocation.getCurrentPosition(getPosition)
    }, 5000);
};
var marker, circle, lat, long, accuracy;
/*
function getPosition(position) {
    // console.log(position)
    lat = position.coords.latitude
    long = position.coords.longitude
    accuracy = position.coords.accuracy

    if (marker) {
        map_init.removeLayer(marker)
    }

    if (circle) {
        map_init.removeLayer(circle)
    }

    marker = L.marker([lat, long])
    circle = L.circle([lat, long], { radius: accuracy })

    var featureGroup = L.featureGroup([marker, circle]).addTo(map_init)

    map_init.fitBounds(featureGroup.getBounds())

    console.log("Your coordinate is: Lat: " + lat + " Long: " + long + " Accuracy: " + accuracy)
}
*/
var latitude = "<?php echo "$latitude"?>";
var longitude = "<?php echo "$longitude"?>";
var visit_estimation = "<?php echo "$visit_estimation"?>";
var average = "<?php echo "$average"?>";
//var x = document.cookie;
//var numbers = [];
//x.replace(/[-+]?[0-9]*\.?[0-9]+/g, function( x ) { var n = Number(x); if (x == n) { numbers.push(x); }  })
//var average = numbers[0];
//visit_estimation = numbers[1];
//latitude = numbers[2];
//longitude = numbers[3];
//console.log(latitude);
//console.log(longitude);
//console.log(average);
//console.log(numbers);
//console.log(visit_estimation);
//console.log(x);

var greenIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var orangeIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var redIcon = new L.Icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

if (visit_estimation <= 32) {
    var marker2 = L.marker([latitude, longitude], {icon: greenIcon}).addTo(map_init);
} else if (33 <= visit_estimation && visit_estimation <= 65) {
    var marker2 = L.marker([latitude, longitude], {icon: orangeIcon}).addTo(map_init);
} else {
    var marker2 = L.marker([latitude, longitude], {icon: redIcon}).addTo(map_init);
}

//var marker2 = L.marker([latitude, longitude], {icon: redIcon}).addTo(map_init);
var popup = marker2.bindPopup('<h3>Visit declaration:</h3><br>The visit estimation of the poi in % is:</br>'+visit_estimation+'<br>The average number of the visitors is:</br>'+average+'\
  <div class="declaration" id="popup">\
  <form action="popup.php" method="post" enctype="multipart/form-data">\
  <label for="input-speed">Estimation of the crowd:</label>\
  <input id="estimation" class="estimation" type="number" name="estimation"/>\
  <button id="button-submit" type="submit">Declare Visit</button>\
</form>\
</div>');






</script>


		</div>
    </body>
</html>
