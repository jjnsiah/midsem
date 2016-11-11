<?php
	session_start();
	if(!isset($_SESSION['USERCODE'])){
		header("Location: login.php");
		exit();
	}
?>
<html>
	<head>
		<title>Home Page</title>
	</head>
	<body>
		This is a secure home page
		<a href="logout.php">logout</a>
	</body>
</html>