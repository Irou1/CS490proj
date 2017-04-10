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
include 'profSession.php';
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
</center>

<div style="text-align: center">

<form method="post">
		
	<!-- Category options -->
	<font color="white" size="3" face="verdana">Category:</font>
		<select name="myCategory" id="myCategory" required>
		<option value="">Please select ...</option>
		<option value="array">Arrays</option>
		<option value="loop">Loops</option>
		<option value="method">Methods</option>
		<option value="relational">Relational</option>
		<option value="recursive">Recursive</option>		
	</select>
	<br>
	<br>

	
	<!-- Diff options -->
	<font color="white" size="3" face="verdana">Difficulty:</font>   <!-- tab space is &emsp; -->
		<select name="myDiff" id="myDiff" required>
		<option value="">Please select ...</option>
		<option value="0">Easy</option>
		<option value="1">Medium</option>
	</select>


	<!-- Return type options -->
	<font color="white" size="3" face="verdana">Return Type:</font>
	<select name="myRtype" id="myRtype" required>
		<option value="">Please select ...</option>
		<option value="int">int</option>
		<option value="double">double</option>
		<option value="float">float</option>
		<option value="char">char</option>
		<option value="String">String</option>
	</select>	

	<br>
	<br>

	<!--Arg Type -->
	<font color="white" size="3" face="verdana">Argument Type</font>
	<div class="dividerA"/></div>
	<!--Number of Args -->
	<font color="white" size="3" face="verdana">Number of Arguments</font>

	<!-- Add One more Arg Type -->
	<button class="btnSmall btn-hover btn-block btn-green-primary" onclick="addOneMoreArgType_Function()">+</button>

	<br>		

	<!-- Arg Type - input -->
	<select name="argt_input[]">
		<option value="">Please select ...</option>
		<option value="int">int</option>
		<option value="double">double</option>
		<option value="float">float</option>
		<option value="char">char</option>
		<option value="String">String</option>
	</select>	
	
	<!--Number of Args - input can only be a number -->
	<input type="number" min="0" placeholder="# of Args of this type" name="num_of_args_input[]" ></td>	
	
	<br>
	<!-- display more arg types -->	
	<p id="moreArg"></p> 
	<br>
	<script>
	function addOneMoreArgType_Function() {
		var abc ='<span><select name="argt_input[]" ><option value="">Please select ...</option><option value="int">int</option><option value="double">double</option><option value="float">float</option><option value="char">char</option><option value="String">String</option></select></span>\r\n';
		document.getElementById('moreArg').innerHTML += abc;  

		var xyz = '<span><input type="number" min="0" placeholder="# of Args of this type" name="num_of_args_input[]" ></td>	 </span><br>\r\n';
		document.getElementById('moreArg').innerHTML += xyz;  
	}
	</script>	
	<br>	
	

	<!-- Question - Input -->
	<font color="white" size="4" face="verdana">Question</font>
	<br>
	<textarea name="q_input" required style="resize:none;" rows="7" cols="60" type="text" class="textInput" placeholder="Enter your Question Here"></textarea>
	<br>

	<!-- Test Case - TextArea -->	
	<textarea name="tc_input" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Here"></textarea>

	<!-- Test Case Answer - TextArea -->
	<textarea name="tcAns_input" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Answer"></textarea>
	<br>	
	<br>

	<!-- Optional - MethodName - form input -->
	<font color="white" size="3" face="verdana">[Optional] Method Name:</font>
	<input type="text" placeholder="Some Method Name" name="methodname_input" class="methodInput"></td>
	<br>

	<!--Optional - Arg Names -->
	<font color="white" size="3" face="verdana">[Optional] Argument Names: </font>
	<input type="text" placeholder="Arg1, Arg2, Arg3, ArgX" name="arg_input" ></td>

	<br>
	<br>
	<input type="reset" class="btn btn-block btn-red-primary">
	<input type="submit" name="send_question" value="Submit" class="btn btn-hover btn-block btn-green-primary" >
</form>
 
	<?php //echo $_POST["q_input"]  ?>



<?php	
//if ( isset($_POST['send_question']) ) {
	function sendQ() {
		
		$arr_Type = array();
		foreach ($_POST['argt_input'] as $type){
			array_push($arr_Type, $type);
			//echo $type;
			//echo "<br>";
		}

		$realTypes="";
		$cnt = 0;
		foreach ($_POST['num_of_args_input'] as $num){
		
			for ($i=0; $i < $num; $i++){
				$realTypes .= $arr_Type[$cnt] . ',';
			}
			$cnt += 1;
		} 
		$realTypes = trim($realTypes, ',');
		//echo $realTypes;

		//echo "<pre>";
		//print_r($_POST['argt_input']);
		//echo "<pre>";

		//JSON data
		$jsonData = array(
		'prof' => $_SESSION['p_ucid'],
		'cat' => $_POST["myCategory"],
		'diff' => $_POST["myDiff"],
		'returnType' => $_POST["myRtype"],
		'argType' => $realTypes, 
		'quest' => $_POST["q_input"],
		'testCase' => $_POST["tc_input"],
		'tcAns' => $_POST["tcAns_input"],
		'methodName' => $_POST["methodname_input"],
		'argName' => $_POST["arg_input"] 
		
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

</div>

</body>
</html>
