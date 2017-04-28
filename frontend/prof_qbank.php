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
	<!-- <link rel="stylesheet" type="text/css" href="qbstyle.css"> -->
	<link rel="stylesheet" type="text/css" href="style.css">


<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>

	<script>
	function addOneMoreArgType_Function() {
		var abc ='<span><select name="argt_input[]" ><option value="">Please select ...</option><option value="int">int</option><option value="double">double</option><option value="float">float</option><option value="char">char</option><option value="String">String</option></select></span>\r\n';
		document.getElementById('moreArg').innerHTML += abc;  

		var xyz = '<span><input type="number" min="0" placeholder="# of Args of this type" name="num_of_args_input[]" ></td>	 </span><br>\r\n';
		document.getElementById('moreArg').innerHTML += xyz;  
	}

	function addOneMoreTestCase_Function() {
		var abcd ='<span><textarea name="tc_input[]" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Here"></textarea></span>\r\n';
		document.getElementById('moreTestCase').innerHTML += abcd;  

		var xyzz = '<span>	<textarea name="tc_ans_input[]" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Answer"></textarea></span><br>\r\n';
		document.getElementById('moreTestCase').innerHTML += xyzz;  
	}	

	</script>

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
		<option value="2">Hard</option>
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
	<!-- Add One more Arg  -->
	<font color="white" size="3" face="verdana">Add More Arguments</font>
	<button class="btnSmall btn-hover btn-block btn-primary" onclick="addOneMoreArgType_Function()">+</button>	
	<p id="moreArg"></p> 
	<br>
	
	<!-- Question - Input -->
	<font color="white" size="4" face="verdana">Question</font>
	<br>
	<textarea name="q_input" required style="resize:none;" rows="7" cols="60" type="text" class="textInput" placeholder="Enter your Question Here"></textarea>
	<br>

	<!-- Test Case - TextArea //gonna change to array-->	
	<textarea name="tc_input[]" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Here"></textarea>

	<!-- Test Case Answer - TextArea //gonna change to array-->
	<textarea name="tc_ans_input[]" style="resize:none;" rows="4" cols="29" type="text" class="textInput" placeholder="Test Case Answer"></textarea>
	<br>

	<!-- Add more Test Cases -->	
	<font color="white" size="3" face="verdana">Add More Test Cases</font>
	<button class="btnSmall btn-hover btn-block btn-primary" onclick="addOneMoreTestCase_Function()">+</button>	
	<p id="moreTestCase"></p> 
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

		//-------------------test cases---------------

		$arr_TC = array();
		foreach ($_POST['tc_input'] as $tc_in){
			array_push($arr_TC, $tc_in);
		}

		$realTestCases="";
		foreach ($arr_TC as $tc){
			$realTestCases .= $tc . '|';
		
		} 
		$realTestCases = trim($realTestCases, '|');


		//-------------------test cases Answers---------------
		$arr_TC_Ans = array();
		foreach ($_POST['tc_ans_input'] as $tc_ans_in){
			array_push($arr_TC_Ans, $tc_ans_in);
		}

		$realTestCasesAns="";
		foreach ($arr_TC_Ans as $tc_ans){
			$realTestCasesAns .= $tc_ans . '|';
		
		} 
		$realTestCasesAns = trim($realTestCasesAns, '|');


		//JSON data
		$jsonData = array(
		'prof' => $_SESSION['p_ucid'],
		'cat' => $_POST["myCategory"],
		'diff' => $_POST["myDiff"],
		'returnType' => $_POST["myRtype"],
		'argType' => $realTypes, 
		'quest' => $_POST["q_input"],
		'testCase' => $realTestCases,
		//'testCase' => $_POST["tc_input"],
		'tcAns' => $realTestCasesAns,
		//'tcAns' => $_POST["tcAns_input"],
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
