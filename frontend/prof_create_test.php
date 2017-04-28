<!--
Kenneth Aparicio 
Front End
CS490

Prof - Create Test
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
	<meta charset="UTF-8">
	<title>CS490 Prof Logged In</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<body>
	<?php
		//create Test and run function to do so
		if ( isset($_POST['create_test']) ) {
			createTest(); //run php - send test
			$_SESSION['message'] = "Test Created!";
			echo "<div id='blue_msg'>".$_SESSION['message']."</div>";
			unset($_SESSION['message']);
		}
	?>
	<center> 
		<h1>Create Test</h1>

		<form method="post">
		<input type="text" name="examName" placeholder="Enter a new Test Name" class="textInput" required>


<?php	
	//To Receive all Questions from question bank

	//MID URL
	$url = "https://web.njit.edu/~or32/rc/receivealltasks.php";

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
	for ($i=0; $i<sizeof($resultz); $i++){	 //loop through questions from question bank
		$j = $i + 1; 
?>		

	<form> <!-- form - display questions  from question bank in read-only text area  -->
		<center>
			<h2> QB Question <?php echo $j ?> </h2>

			<input type='checkbox' name='questionList[]' value="<?php echo $resultz[$i]; ?>"> 
			<textarea name = "qbank" readonly class="input" rows="7" cols="60"> <?php print_r ($resultz[$i]) ?> </textarea> 
			<!--Points assigned testing  -->
			<input type="number" min="0" style="width: 60px" name ='pointsAssigned[]' placeholder="Pts" maxlength="2" size="1">

			<br>
			<?php }  //for loop - curly brace?> 

<?php	
//Add Test questions to X Test aka Create Test

	function createTest() {
		//OLD WAY - JSON data
		/*
		$jsonData[0] = $_POST['examName'];
      	$x = 1;
      	
      	foreach($_POST['questionList'] as $value){
        	$jsonData[$x] = $value;
	 		$x++;
      	} 
		*/

		//-------------------Sending Questions --------------------------
		$q_arr = array();
		foreach ($_POST['questionList'] as $qSelected){
			array_push($q_arr, $qSelected);
		}

		$realQuestions="";
		foreach ($q_arr as $q){
			$realQuestions .= $q . '|';
		} 
		$realQuestions = trim($realQuestions, '|');

		//-------------------Sending Points assigned to question---------------
		$pts_arr = array();
		foreach ($_POST['pointsAssigned'] as $ptsInput){
			array_push($pts_arr, $ptsInput);
		}

		$realPoints="";
		foreach ($pts_arr as $pts){
			$realPoints .= $pts . ',';
		} 
		$realPoints = trim($realPoints, ',');

		//JSON data
		$jsonData = array(
		'examName' => $_POST['examName'],
		'questions' => $realQuestions,
		'points' => $realPoints
		); 



		//MID URL
		$url = "https://web.njit.edu/~or32/rc/sendexam.php";

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
	}
	
?>

		<br>
		<button type="submit" name="create_test" class="btn btn-block btn-primary" >Create Test</button></td>
		<br>
		<br>
		</center>
	</form>


</body>
</html>
