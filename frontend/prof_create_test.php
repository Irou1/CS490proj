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
	//JSON data
	//$jsonData = array(
	//'flag' => 'test',
	//'mode' => 'view'
	//);
	
	//MID URL
	$url = "https://web.njit.edu/~or32/rc/receivetasks.php";
	//$url = "https://web.njit.edu/~or32/beta/midcontrol.php";
	//$url = "http://192.168.1.136/cs490/midcontrol.php"; //oscar house
	//$url = "http://172.20.10.12/cs490/midcontrol.php"; //myiPhone



	//initiate cURL
	$ch = curl_init($url);
	
	//Tell cURL that we want to send a POST request
	//curl_setopt($ch, CURLOPT_POST, true);
	
	//Attach our encoded JSON string to the POST fields
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	
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
