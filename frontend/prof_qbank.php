<!--
Kenneth Aparicio 
Front End
CS490

Prof - Create Questions
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
<?php
	if ( isset($_POST['send_question']) ) {
		sendQ(); //run php - send question
		$_SESSION['message'] = "Question added to Question Bank!";
		echo "<div id='error_msg'>".$_SESSION['message']."</div>";
		unset($_SESSION['message']);
	}
?>

<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
	<h1>Question Creator</h1>
</center>	

<div id="container">
	<!-- <center>-->

	    <!-- left side -->
	    <div id="left">	
		
		<form method="post">
		
		<h3>Category:</h3><select name="myCategory" id="myCategory">
			<option value="nada">Please select ...</option>
			<option value="array">Arrays</option>
			<option value="loop">Loops</option>
			<option value="method">Methods</option>
			<option value="statement">Statements</option>
		</select>
		<br>
		<br>

		<h3> Difficulty:</h3><select name="myDiff" id="myDiff">
			<option value="nada">Please select ...</option>
			<option value="0">Easy</option>
			<option value="1">Medium</option>
		</select>
		<br>
		<br>


	<!-- <form method="post"> -->
	<h3>Question:</h3><br>
<textarea name="q_input" style="resize:none;" rows="7" cols="60" type="text" class="textInput" placeholder="Enter your question here">
	<?php
	if (isset($_POST["myCategory"])){ //== "nada" && $_GET["myDiff"] == "nada") {
		for ($i=0; $i<sizeof($resultz); $i++){	
			if ($resultz[$i]['category'] == $_POST["myCategory"]){
				//echo $userInputCategory;
				if($resultz[$i]['difficulty'] == $_POST["myDiff"]){
					//echo $userInputDif;
					echo $resultz[$i]['text'];
				}
			}
		}
	}
		//$_POST["q_input"] send this to oscar
	?>
	</textarea> 
	<br>
	<br>
	<input type="reset" class="btn btn-block btn-red-primary">
	<input type="submit" name="send_question" value="Submit" class="btn btn-hover btn-block btn-green-primary" >
	</form>

	<?php //echo $_POST["q_input"]  ?>
		</div>
	<!--</center> -->
</div>



<?php	
//if ( isset($_POST['send_question']) ) {
	function sendQ() {
	//function php_curl(){
		//JSON data
		$jsonData = array(
		'flag' => 'task',
		'mode' => 'checktask',
		'prof' => $_SESSION['p_ucid'],
		'cat' => $_POST["myCategory"],
		'diff' => $_POST["myDiff"],
		'quest' => $_POST["q_input"] 
		);
		
		//MID URL
		$url = "https://web.njit.edu/~or32/beta/midcontrol.php";
		//$url = "http://192.168.1.136/cs490/midcontrol.php"; //oscar house
		//$url = "http://172.20.10.12/cs490/midcontrol.php"; //myiPhone

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
		print('<pre>');
		print_r ($resultz);
		print('</pre>');
	}
	
?>


</body>
</html>
