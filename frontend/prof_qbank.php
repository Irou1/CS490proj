<!--
Kenneth Aparicio 
Front End
CS490

Prof - Create Questions
 -->
 
<?php
//show errors
include 'showerrors.php';

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
		
		<!-- Catagory options -->
		<h3>Category:</h3><select name="myCategory" id="myCategory">
			<option value="nada">Please select ...</option>
			<option value="array">Arrays</option>
			<option value="loop">Loops</option>
			<option value="method">Methods</option>
			<option value="statement">Statements</option>
		</select>
		<br>
		<br>
		
		<!-- Diff options -->
		<h3> Difficulty:</h3><select name="myDiff" id="myDiff">
			<option value="nada">Please select ...</option>
			<option value="0">Easy</option>
			<option value="1">Medium</option>
		</select>
		<br>
		<br>

		<!-- Return type options -->
		<h3> Return Type:</h3><select name="myRtype" id="myRtype">
			<option value="nada">Please select ...</option>
			<option value="int">Int</option>
			<option value="double">Double</option>
			<option value="float">Float</option>
			<option value="char">Char</option>
			<option value="string">String</option>
		</select>
		<br>
		<br>

		<!-- MethodName - form input -->
		<h3> Method Name: Fill in if required</h3>
		<input type="text" placeholder="Some Method Name" name="methodname_input" class="methodInput"></td><br><br>

		<!--Arg Names -->
		<h3> Argument Names (separated by a comma)</h3>
		<input type="text" placeholder="Arg1, Arg2" name="arg_input" ></td>
		<br><br>		

		<!--Arg Type -->
		<h3> Argument Types (separated by a comma)</h3>
		<input type="text" placeholder="Arg1Type, Arg2Type" name="argt_input" ></td>
		<br><br>					
		
		<!-- Question - Input -->
		<h3>Question:</h3><br>
		<textarea name="q_input" style="resize:none;" rows="7" cols="60" type="text" class="textInput" placeholder="Enter your Question Here"></textarea>
		<br>

		<!-- Test Case  <h3>Test Case:</h3><br> -->
		<textarea name="tc_input" style="resize:none;" rows="7" cols="20" type="text" class="textInput" placeholder="Test Case Here"></textarea>


		<!-- Test Case Answer -->
		<textarea name="tcAns_input" style="resize:none;" rows="7" cols="20" type="text" class="textInput" placeholder="Test Case Answer"></textarea>
		<br>	


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
		'prof' => $_SESSION['p_ucid'],
		'cat' => $_POST["myCategory"],
		'diff' => $_POST["myDiff"],
		'quest' => $_POST["q_input"],
		'returnType' => $_POST["myRtype"],
		'methodName' => $_POST["methodname_input"],
		'argName' => $_POST["arg_input"], 
		'argType' => $_POST["argt_input"],
		'testCase' => $_POST["tc_input"],
		'tcAns' => $_POST["tcAns_input"]
		);
		
		//MID URL
		$url = "https://web.njit.edu/~or32/rc/sendtask.php";

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


</body>
</html>
