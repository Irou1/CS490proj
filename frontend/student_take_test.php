<!--
Kenneth Aparicio 
Front End
CS490

Student - Take Test
 -->

 <?php
//start session
session_start();
 ?>


</script>

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

<?php	
	//JSON data
	$jsonData = array(
	'flag' => 'test',
	'mode' => 'view'
	);
	
	//MID URL
	$url = "https://web.njit.edu/~or32/beta/midcontrol.php";

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

	$resultz = json_decode($result, 1);	//json decode

	//display resultz - json array
	//print('<pre>');
	//print_r ($resultz);
	//print('</pre>');
	
?>	
<?php
	for ($i=0; $i<sizeof($resultz); $i++){	 //loop through questions
		$j = $i + 1; 
?>		

<form action="student_submit_test.php" name="student_input" method="post" >

	<!--display questions in read-only text area  -->
	<h2> Question <?php echo $j ?> </h2> 
	<textarea name = "test_questions" readonly class="input" rows="7" cols="60"> <?php print_r ($resultz[$i])  ?></textarea>

	<!--student input aka student answer-->
	<textarea id="studentAnsInput" class ="input" rows="7" cols="60" placeholder="Enter your answer here" name="studentAnsInput<?php echo $j ?>"></textarea>

<?php }  //for loop curly brace?>
<br>
	<button type="submit" class="submitButton">Submit</button>
	<!-- <input type="reset"> -->
</form>


<br><br><br><br><br><br><br><br>



</center>
</body>
</html>
