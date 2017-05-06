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
		<font color="white" size="6" face="verdana">Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </font><br>
		<h1>Create Test</h1>

		<form method="post">
		<input type="text" name="examName" placeholder="Enter a new Test Name" class="textInput" required>
		<br><br>


<?php	
	//To Receive all Questions from question bank

	//MID URL
	$url = "https://web.njit.edu/~or32/rc/receivealltasks.php";

	//initiate cURL
	$ch = curl_init($url);
	
	//returns $url stuff
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	 //Execute the request
	$questions = curl_exec($ch);
	
	//close cURL 
	curl_close($ch);
	
	//echo gettype ( $questions );		//get var type 

	$qResultz = json_decode($questions, 1);	//json decode


	//display resultz - json array
	//print('<pre>');
	//print_r ($resultz);
	//print('</pre>');
	
?>	
<?php //testing for js 

/*
$categoryArr = array("relational", "relational", "relational, method, method, method, relational, relational, loop, array, loop, loop, method, relational, method, method, method, method, relational, method, loop, loop, loop, relational");

$catJsonArray = json_encode($categoryArr);

$diffArr = array(0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 2, 2, 0, 1, 0, 0, 1, 2, 2, 0);

$diffJsonArray = json_encode($diffArr);
*/

?>


<script type="text/javascript">

	var result = <?php echo $question; ?>;
	var indexArray = <?php echo $diffJsonArray; ?>;
	var categories = <?php echo $catJsonArray; ?>;

	var filteredQuestions = [];
	var finalQuestions = "";

	window.document.onload = function(e){ 
	    filteredQuestions = <?php echo $question; ?>;
	    finalQuestions = JSON.stringify(filteredQuestions);
	    postStuff(finalQuestions);
	}


	function selectDifficulty(){
		var myDiff = document.getElementById("myDiff").value;

		filteredQuestions = [];

		if(!isNaN(myDiff)){
			myDiff = parseInt(myDiff);
			for(var i=0;i<indexArray.length;i++){
				//select questions that matches criteria
				if (indexArray[i]==myDiff){
					filteredQuestions.push(question[i]);
				}
				//console.log(indexArray[i]);
			}
			console.log(myDiff);
		}
		else{
			console.log(myDiff)
		}

		finalQuestions = JSON.stringify(filteredQuestions);
		postStuff(finalQuestions);
	}


	function postStuff(toPass){
		// Create our XMLHttpRequest object
		var hr = new XMLHttpRequest();
		// Create some variables we need to send to our PHP file
		var url = "prof_create_test.php";
		
		var vars = "finalQuestions="+ toPass;
		hr.open("POST", url, true);
		hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		// Send the data to PHP now... and wait for response to update the status div
		hr.send(vars); // Actually execute the request
		console.log(hr);
		}
</script>
<?php
	//testing for JS
	//$filteredQuestions = json_decode($_POST['finalQuestions']);
	$filteredQuestions = json_decode(stripslashes($_POST['finalQuestions']));

	
	echo gettype($filteredQuestions);
?>


	<!-- Category options -->
	<font color="white" size="3" face="verdana">Category:</font>
		<select name="myCategory" id="myCategory" required>
		<option value="nada">Please select ...</option>
		<option value="array">Arrays</option>
		<option value="loop">Loops</option>
		<option value="method">Methods</option>
		<option value="relational">Relational</option>
		<option value="recursive">Recursive</option>		
	</select>
	<br><br>
	<!-- Diff options -->
	<font color="white" size="3" face="verdana">Difficulty:</font>   <!-- tab space is &emsp; -->
		<select name="myDiff" id="myDiff" required onchange="selectDifficulty()">
		<option value="nada">Please select ...</option>
		<option value="0">Easy</option>
		<option value="1">Medium</option>
		<option value="2">Hard</option>
	</select>
	<br><br>	
	
<?php
	for ($i=0; $i<sizeof($qResultz); $i++){	 //loop through questions from question bank
		$j = $i + 1; 
?>		

	<form> <!-- form - display questions  from question bank in read-only text area  -->
		<center>
			<h2> QB Question <?php echo $j ?> </h2>

			<input type='checkbox' name='questionList[]' value="<?php echo $qResultz[$i]; ?>"> 
			<textarea name = "qbank" readonly class="input" rows="7" cols="60"> <?php print_r ($qResultz[$i]) ?> </textarea> 
			<!--Points assigned testing  -->
			<input type="number" min="1" style="width: 60px" name ='pointsAssigned[]' placeholder="Pts" maxlength="2" size="1">

			<br>
			<?php }  //for loop - curly brace?> 

<?php	
//Add Test questions to X Test aka Create Test

	function createTest() {

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
			if ($ptsInput > 0){ 
				array_push($pts_arr, $ptsInput);
			}
		}

		$realPoints="";
		foreach ($pts_arr as $pts){
			$realPoints .= $pts . ',';
		} 
		$realPoints = trim($realPoints, ',');

		//JSON data
		$jsonData = array(
		'prof' => $_SESSION['p_ucid'],
		'examName' => $_POST['examName'],
		'questions' => $realQuestions,
		'points' => $realPoints

		); 

		/*
	    print('<pre>');
	    print_r ($jsonData); //display my stuff
	    print('</pre>');  	
	    */


		//MID URL

		//$url = "https://web.njit.edu/~or32/xr/sendexam.php";
        $url = "http://afsaccess2.njit.edu/~or32/xr/sendexam.php";

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
