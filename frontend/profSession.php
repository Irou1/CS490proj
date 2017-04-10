<?php

	//if session prof ucid is set, it's true -> you are logged in
	if (isset($_SESSION['p_ucid'])) {
		//echo "You have successfully logged in Prof!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}

	
?>