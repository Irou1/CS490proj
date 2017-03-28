<?php
	session_start();
	session_destroy();
	unset($_SESSION['ucid']);
	$_SESSION['message'] = "You are now logged out";
		
	header("location: kfront.php");
?>