<!DOCTYPE HTML>
<html>
	<?php
		session_start();
		
		//Ha nem létezik a session visszadob a loginhoz
		if(!isset($_SESSION["Name"])){
			header("Location: login.php");
		}
	?>
	<head>
	
	</head>
	<body>
		<!--Kiírja a sessionben tárolt nevet-->
		<h1><?php echo $_SESSION["Name"].", ",$_SESSION["Id"];?></h1>
		
		<a href="logout.php">Kijelentkezés</a>
	</body>
</html>