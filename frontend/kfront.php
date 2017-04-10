<!--
Kenneth Aparicio 
Front End 
CS490

Login Page

0=unsucc, 1=succ
0=student, 1 prof

 -->
 
<?php
//start session
session_start();
?>

<?php	
	//check session if student or prof
	if (isset($_SESSION['s_ucid'])) {
		$_SESSION['message'] = "you're a student, not a prof! quit tryna hack your PROF!";
	}
	/*
	if(isset($_SESSION['p_ucid'])) {
		$_SESSION['message'] = "you're a prof, not a student!";
	}
	*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CS490 Proj</title>
	<link rel="stylesheet" type="text/css" href="login.css">

</head>
<body> 
<?php
	if (isset($_SESSION['message'])) {
		echo "<div id='error_msg'>".$_SESSION['message']."</div>";
		unset($_SESSION['message']);
	}
?>
<center>



	
<form method="post" action="kfront.php">
	<h2>CS490 Login</h1>
	<table>
		<tr>
			<td><input type="text" placeholder="UCID" name="ucid_input" class="textInput"></td>
		</tr>
		<tr>
			<td><input type="password" placeholder="Password" name="password_input" class="textInput"></td>
		</tr>
		<tr>
			<td><button type="submit" name="login_button" class="btn btn-block btn-primary" >Login</button></td>
		</tr>
	</table>
</form>


<?php
//if(isset($_POST['ucid_input']) && isset($_POST['password_input'])){
if (isset($_POST['login_button'])) {
	
	//JSON data
	$jsonData = array(
	//'flag' => 'login',
	'ucid' => $_POST['ucid_input'],
	'pass' => $_POST['password_input']
	);
	
	//MID URL
	$url = "https://web.njit.edu/~or32/rc/midlogin.php";
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
	/*print('<pre>');
	print_r ($resultz);
	print('</pre>');
	*/

	if ($resultz[0] == 1 && $resultz[1] == 0){
		//echo "STUDENT - Successfully Logged In!";
		$_SESSION["s_ucid"] = $_POST['ucid_input']; // set student-ucid SESSION
		header("location: student_home.php");

	} elseif ($resultz[0] == 1 && $resultz[1] == 1) {
		//echo "PROF - Successfully Logged In!";
		$_SESSION["p_ucid"] = $_POST['ucid_input']; // set prof-ucid SESSION
		header("location: prof_home.php");

	}else {
		//echo "no session";
		$_SESSION['message'] = "Username/password combination incorrect";
	} 
} 

?>
</center>
</body>
</html>
