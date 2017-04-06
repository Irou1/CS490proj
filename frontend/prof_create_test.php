<!--
Kenneth Aparicio 
Front End
CS490

Prof - Create Test
 -->

<?php
//start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CS490 Prof Logged In</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<body>
	<center> 
		<h1>Create Test</h1>
	</center>
<?php	

	//MID URL
	$url = "https://web.njit.edu/~or32/rc/receivetasks.php";

	//initiate cURL
	$ch = curl_init($url);
	
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

<div id="container">
	<div id ="left">
		<form>
			<!--display questions in read-only text area  -->
			<center>
				<h2> Test Question <?php echo $j ?> </h2> 
				<textarea name = "currentTest" class ="input" rows="7" cols="60" placeholder="Enter test stuff here"></textarea>
			</center>
		</form>	
	</div>

	<div id="right">
		<form>
			<!--display questions  from question bank in read-only text area  -->
			<center>
				<h2> QB Question <?php echo $j ?> </h2>
				<textarea name = "qbank" readonly class="input" rows="7" cols="60"> <?php print_r ($resultz[$i]) ?> </textarea> 
			</center>
		</form>
	</div>	
		<?php }  //for loop curly brace?> 

</div> <!-- div end - container -->



</center>
</body>
</html>
