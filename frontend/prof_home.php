<!--
Kenneth Aparicio 
Front End
CS490

Prof - Home Page
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
	if (isset($_GET['BURN'])) { //display test deleted when activated
		burnFunction(); //run php delete test function
		$_SESSION['message'] = "Test successfully deleted!";
		echo "<div id='error_msg'>".$_SESSION['message']."</div>";
		unset($_SESSION['message']);
	}
?>
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
	<?php	

	//if session prof ucid is set, it's true -> you are logged in
	if (isset($_SESSION['p_ucid'])) {
		//echo "You have successfully logged in Prof!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}

	?>



<form>
	<br>
	<input type="button" value="Create Questions" class="btn btn-hover btn-block btn-primary" onclick="window.location.href='prof_qbank.php'" />
	<input type="button" value="Create Test" class="btn btn-hover btn-block btn-primary" onclick="window.location.href='prof_create_test.php'" />
	<input type="button" value="Manage Tests" class="btn btn-hover btn-block btn-primary" onclick="window.location.href='prof_manage_test.php'" />
	<br></br>
	<input type="button" value="Grade Test" class="btn btn-hover btn-block btn-green-primary" onclick="window.location.href='prof_grade_test.php'" />
	<input type="button" value="Publish Scores" class="btn btn-hover btn-block btn-green-primary" onclick="window.location.href='prof_post_results.php'" />
</form>


<?php
  function burnFunction() {
    //echo 'Run php function!';

    	//JSON data
	$jsonData = array(
	'flag' => 'test',
	'mode' => 'burn'
	);
	
	//MID URL
	$url = "https://web.njit.edu/~or32/beta/midcontrol.php";

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
  }
?>
<br><br>
<button class="btn btn-block btn-red-primary" onclick="window.location.href='prof_home.php?BURN=true'" />Delete Test</button>
<!-- Burn function above -->



</center>
</body>
</html>
