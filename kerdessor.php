<!DOCTYPE HTML>

<?php

	//Adatbázis adatai
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "project_testing";

	//Session elindítása
	session_start();

	// Connection string
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Ha nem jött létre a kapcsolat hibát dob
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	if(isset($_SESSION["Name"])){
		header("Location: index.php");
	}
	
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kérdéssor összeállítás</title>
</head>
<body>
	<?php
	
	?>
</body>
</html>