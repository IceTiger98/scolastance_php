<!DOCTYPE html>
<html>
<head>
	<title>Scolastance - Déconnection</title>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/x-icon" href="../images/logo.png" />
</head>
<body>
	<h3>Vous avez bien été déconnecté de la session.</h3>

	<?php
		session_start();
		if(isset($_SESSION["login"])){
			//destruction de la session et redirection vers la page login.php
			unset($_SESSION);
			session_destroy();
			header("Location:login.php");
		}

	?>
	
</body>
</html>