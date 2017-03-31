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
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
</center>	

    <div id="container">

    <!-- left side -->
    <div id="left">	
	<h1>Create Question</h1>

<form method="get">
Select Category:
<select name="myCategory">
	<option value="nada">Please select ...</option>
	<option value="array">Arrays</option>
	<option value="loop">Loops</option>
	<option value="method">Methods</option>
	<option value="statement">Statements</option>
</select>
<br>
<br>


Select Difficulty:
<select name="myDiff" id="myDiff">
	<option value="nada">Please select ...</option>
	<option value="0">Easy</option>
	<option value="1">Medium</option>
</select>
<br>
<br>


<input type="submit" name="gen_question" value="Generate Question">
</form>


<?php
	
	//JSON data
	$jsonData = array(
	'flag' => 'task',
	'mode' => 'receive'
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
	//print('<pre>');
	//print_r ($resultz);
	//print('</pre>');
?>

<form method="post">
Question: <br><textarea name="q_input" style="resize:none;" type="text" class="textInput" placeholder="Enter your question here">
<?php
if (isset($_GET["myCategory"])){ //== "nada" && $_GET["myDiff"] == "nada") {
	for ($i=0; $i<sizeof($resultz); $i++){	
		if ($resultz[$i]['category'] == $_GET["myCategory"]){
			//echo $userInputCategory;
			if($resultz[$i]['difficulty'] == $_GET["myDiff"]){
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
<input type="submit" name="send_question" value="Submit">
<input type="reset">
</form>

<?php //echo $_POST["q_input"]  ?>

<?php	
if (isset($_POST['send_question'])) {
	//function php_curl(){
		//JSON data
		$jsonData = array(
		'flag' => 'task',
		'mode' => 'checktask',
		'prof' => $_SESSION['p_ucid'],
		'cat' => $_GET["myCategory"],
		'diff' => $_GET["myDiff"],
		'quest' => $_POST["q_input"] 
		);
		
		//MID URL
		//$url = "https://web.njit.edu/~or32/mid.php";
		//$url = "http://192.168.1.136/cs490/midcontrol.php"; //oscar house
		$url = "http://172.20.10.12/cs490/midcontrol.php"; //myiPhone

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
</div>

</div>

</body>
</html>
