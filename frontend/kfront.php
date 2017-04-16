<!--
Kenneth Aparicio 
Front End 
CS490

Login Page

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



	
<form method="post" class ="loginForm" action="kfront.php">
	<h1>CS490 Login</h1>
	<table>
		<tr>
			<!-- <td>UCID:</td> -->
			<td><input type="text" placeholder="UCID" name="ucid_input" class="textInput"></td>
		</tr>
		<tr>
			<!-- <td>Password:</td> -->
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

	}elseif ($resultz[0] == 0 && $resultz[1] == 0) {
		//echo "no session";
		$_SESSION['message'] = "Username/password combination incorrect";
	}

} 

?>




<?php //testing   ?>
<style>
.tableBottom {
color: #333; /* Lighten up font color */
font-family: Helvetica, Arial, sans-serif; 
width: 620px;
border-collapse:
collapse; border-spacing: 0;
position: absolute;
bottom: 0px;
}

#teamTable {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#teamTable td, #teamTable th {
    border: 1px solid #ddd;
    padding: 8px;
    /*background-color: black; 
    color: white;    
    */
}

#teamTable tr:nth-child(even){background-color: #f2f2f2;} 

#teamTable tr:hover {background-color: #c2c2d6;}

#teamTable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    vertical-align: middle;
    background-color: #0066ff; /* blue*/
    color: white;
}
</style>


	<table id="teamTable" class="tableBottom" style="width:28%" >
	  <tr>
	    <th>Front End</th>
	    <th>Middle</th>
	    <th>Back End</th>
	  </tr>
	  <tr>
	    <td>Kenneth Aparicio</td>
	    <td>Oscar Rodriguez</td>
	    <td>Edward Martin</td>
	  </tr>
	</table>

</center>

</body>
</html>
