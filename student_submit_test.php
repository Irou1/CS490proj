<!--
Kenneth Aparicio 
Front End
CS490

Student - Submit Test
 -->

 <?php
//start session
session_start();
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CS490 Student Test Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>


<body>
<center>
	<h1>Thank You <?php echo ucfirst($_SESSION['s_ucid']) ?> for Submitting</h1>
	
	<?php	
	//if session student ucid is set, it's true -> you are logged in
	if (isset($_SESSION['s_ucid'])) {
		//echo "You have successfully logged in Student!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}
	?>

<h2> Student Answers </h2>
<?php
	for ($i=0; $i<4; $i++){	 //loop through answers
		$j = $i + 1; 
	
//testing

  $someJSON = json_encode($_POST["studentAnsInput$j"]);
  echo $someJSON;

 }  //for loop curly brace?> 



<br><br><br><br><br><br><br><br>



</center>
</body>
</html>
