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
	<link rel="stylesheet" type="text/css" href="qbstyle.css">


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


<form method="post">
		
	<!-- Catagory options -->
	<font color="white" size="3" face="verdana">Category:</font>
		<select name="myCategory" id="myCategory">
		<option value="nada">Please select ...</option>
		<option value="array">Arrays</option>
		<option value="loop">Loops</option>
		<option value="method">Methods</option>
		<option value="statement">Statements</option>
	</select>

	
	<!-- Diff options -->
	<font color="white" size="3" face="verdana">&emsp; Difficulty:</font>   <!-- tab space is &emsp; -->
		<select name="myDiff" id="myDiff">
		<option value="nada">Please select ...</option>
		<option value="0">Easy</option>
		<option value="1">Medium</option>
	</select>

	<!-- Return type options -->
	<font color="white" size="3" face="verdana"> Return Type:</font>
	<select name="myRtype" id="myRtype">
		<option value="nada">Please select ...</option>
		<option value="int">int</option>
		<option value="double">double</option>
		<option value="float">float</option>
		<option value="char">char</option>
		<option value="String">String</option>
	</select>	
	<br>
	<br>

	<!-- Optional - MethodName - form input -->
	<font color="white" size="3" face="verdana">[Optional] Method Name:</font>
	<input type="text" placeholder="Some Method Name" name="methodname_input" class="methodInput"></td>
	<br>

	<!--Optional - Arg Names -->
	<font color="white" size="3" face="verdana">[Optional] Argument Names: </font>
	<input type="text" placeholder="Arg1, Arg2" name="arg_input" ></td>
	<br>
	<br>

	<!--Arg Type -->
	<font color="white" size="3" face="verdana">Argument Type </font>
	<!--Number of Args -->
	<font color="white" size="3" face="verdana">&emsp; Number of Arguements</font>
	<br>
	

	<!-- Arg Type - input -->
	<select name="argt_input" id="argt_input">
		<option value="nada">Please select ...</option>
		<option value="int">int</option>
		<option value="double">double</option>
		<option value="float">float</option>
		<option value="char">char</option>
		<option value="String">String</option>
	</select>		

	<!--Number of Args - input -->
	<input type="text" placeholder="# of Args of this type" name="num_of_args_input" ></td>	
	<br>
	<br>	
	

	<!-- Question - Input -->
	<font color="white" size="3" face="verdana">Question</font><br>
	<textarea name="q_input" style="resize:none;" rows="7" cols="60" type="text" class="textInput" placeholder="Enter your Question Here"></textarea>
	<br>

	<!-- Test Case - TextArea -->	
	<textarea name="tc_input" style="resize:none;" rows="7" cols="29" type="text" class="textInput" placeholder="Test Case Here"></textarea>

	<!-- Test Case Answer - TextArea -->
	<textarea name="tcAns_input" style="resize:none;" rows="7" cols="29" type="text" class="textInput" placeholder="Test Case Answer"></textarea>
	<br>	


	<br>
	<br>
	<input type="reset" class="btn btn-block btn-red-primary">
	<input type="submit" name="send_question" value="Submit" class="btn btn-hover btn-block btn-green-primary" >
</form>
 
	<?php //echo $_POST["q_input"]  ?>



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

</center>	
</body>
</html>
