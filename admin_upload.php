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
		<title>Upload Data</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">


	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Covid-19 Tracing</h1>

				<!-- Navigation Bar -->
				<a href="admin.php"><i class="fas fa-user"></i>Home Page</a>
				<a href="admin_stats.php"><i class="fas fa-chart-line"></i>Stats</a>
				<a href="admin_upload.php"><i class="selected fas fa-cloud-upload-alt"></i>Upload</a>
				<a href="admin_delete.php"><i class="fas fa-trash-restore-alt"></i>Delete</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

			</div>
		</nav>

		<div class="content">
			<h2>Upload Data</h2>
			<p>Select the location of file in JSON format.</p>
            <div>
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<label for="month">Filename:</label>
				<input type="file" name="file" id="file">
				<input type="hidden" name="areas" id="areas" value="[]">
				<input type="submit" name="submit" value="Submit">
			</form>
            </div>
			<p>When uploading big JSON files it will take a while to process all the locations. Please be patient.</p>

		</div>


	</body>
</html>