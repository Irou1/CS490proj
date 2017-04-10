<?php	

	//if session student ucid is set, it's true -> you are logged in
	if (isset($_SESSION['s_ucid'])) {
		//echo "You have successfully logged in Student!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}
?>