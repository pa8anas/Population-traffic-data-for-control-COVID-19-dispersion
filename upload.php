<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Upload Data</title>
		<link href="style_.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>CrowdScope</h1>

                <!-- Navigation Bar -->
                <a href="admin.php"><i class="fas fa-user"></i>Dashboard</a>
                <a href="admin_stats.php"><i class="fas fa-chart-line"></i>Stats</a>
                <a href="admin_upload.php"><i class="selected fas fa-cloud-upload-alt"></i>Upload</a>
                <a href="admin_delete.php"><i class="fas fa-trash-restore-alt"></i>Delete</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>

			</div>
		</nav>
		<div class="content">
			<h2>Upload Data</h2>

			<?php
				// Include the database
				require('config.php');
				// Resume the previous session
				session_start();
				// If the user is not logged in redirect to the login page
				if (!isset($_SESSION['loggedin'])) {
					header('Location: index.html');
					exit();
				}
				ini_set('display_errors', 1);
				ini_set('display_startup_errors', 1);
				error_reporting(E_ALL);
				require_once('vendor/autoload.php');
				//require_once('functions.php');

				// Load the censored areas
				$rect = json_decode($_POST["areas"], true);

				if(isset($_POST["submit"]) && isset($_POST["areas"])) {

					$target_path = $_SERVER['DOCUMENT_ROOT']."uploads";

					if (file_exists($target_path.$_FILES["file"]["name"])) {
						// echo "<p>An error occured while uploading your data. Please try again.</p>";
						unlink($target_path.$_FILES["file"]["name"]);
					}
					move_uploaded_file($_FILES["file"]["tmp_name"], $target_path.$_FILES["file"]["name"]);
					// Load file process
					try {
						// Create the pointer for the JSON parser
						$jsonStream = \JsonMachine\JsonMachine::fromFile($target_path.$_FILES["file"]["name"]);
						// Counters to count the number of locations that were processed
						$cnt = 0;
						$userid = $_SESSION["id"];
						// For each entry in the JSON
						foreach ($jsonStream as $name => $data) {
							// Load information
							$id = $data["id"];
                            $name = $data["name"];
                            $address = $data["address"];
                            $latitude = $data["coordinates"]["lat"];
                            $longitude = $data["coordinates"]["lng"];
                            $array = $data["types"];
                            $categories = implode(',',$array);
                            // Create insert query
								$query = "INSERT INTO data (userid, id, name, address, latitude, longitude, categories) VALUES ('$userid', '$id', '$name', '$address', '$latitude', '$longitude', '$categories')";
								$con->query($query);
								// Increment the counter
								$cnt = $cnt + 1;
								//echo "<h2>" . $query . "</h2>";

						}
					} catch (Exception $e) {
						echo "<p>Something went wrong. Please try again.</p>";
					}
					//unlink($target_path.$_FILES["file"]["name"]);
					echo "<p>Uploaded $cnt locations successfully!</p>";
				} else {
					echo "<p>Something went wrong. Please try again.</p>";
				}
				$con->close();
			?>

		</div>
	</body>
</html>