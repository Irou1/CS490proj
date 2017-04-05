<!--
Kenneth Aparicio 
Front End
CS490

Student - Home Page
 -->

 <?php
//start session
session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CS490 Student Logged In</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>


<body>
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </h1>
	
	<?php	
	//if session student ucid is set, it's true -> you are logged in
	if (isset($_SESSION['s_ucid'])) {
		//echo "You have successfully logged in Student!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}
	?>

<form>
<br></br>
<input type="button" value="Take Test" onclick="window.location.href='student_take_test.php'" />
<input type="button" value="View Score" onclick="window.location.href='student_view_score.php'" />
</form>

</center>
</body>
</html>
