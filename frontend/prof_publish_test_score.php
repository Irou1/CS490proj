<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Post Results -> Prof Get Student Test -> Prof get student Test page -> [Prof Publish Test Score]
 -->

 <?php
//show errors
include 'showerrors.php';
 
//start session
session_start();
include 'profSession.php';
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<title>CS490 Prof Publish Student Test Score Redirecting</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>	
</head>

<body>
<center>
<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
<h1>Thank You for grading <?php echo ucfirst($_SESSION['studentName']) ?> </h1>
</center>

<?php

   //redirect to test page
   $selectedStudentTest = $_POST['testNameList'][0];
 
   echo $selectedStudentTest;
   echo "<br>";

?>

<?php

	//JSON data
	$jsonData = array(
	'studentName' => $_SESSION['studentName'],
	'examName' => $selectedStudentTest
	//'flag' => 1

	);


	//print_r($jsonData); 		//Testing - printing all jsonData****
    //echo "<br>";
	
	
	//MID URL
	$url = "https://web.njit.edu/~or32/rc/changeviewflag.php";
	//$url = "https://web.njit.edu/~em244/CS490/changeExamStatus.php";

	//initiate cURL
	$ch = curl_init($url);
	
	//Tell cURL that we want to send a POST request
	curl_setopt($ch, CURLOPT_POST, true);
	
	//Attach our encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	
	//returns $url stuff
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	 //Execute the request
	$result = curl_exec($ch);
	
	//close cURL 
	curl_close($ch);
	
	//echo gettype ( $result );		//get var type 

	echo $result; 				//testing - echo middle 

	$resultz = json_decode($result, 1);	//json decode

	//display resultz - json array
	//print('<pre>');
	//print_r ($resultz);
	//print('</pre>');
	

?>

</body>
</html>