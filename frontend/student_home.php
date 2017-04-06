<!--
Kenneth Aparicio 
Front End
CS490

Student - Home
 -->

 <?php
//start session
session_start();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CS490 Student Home Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="studentscript.js"></script>
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<?php
	//MID URL - get Test Names
	$url = "https://web.njit.edu/~or32/rc/receivealltests.php";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $DATA);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tests = curl_exec($ch);
    curl_close($ch);
?>

<body>
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </h1>
	
	<?php	
	//if session student ucid is set, it's true -> you are logged in
	if (isset($_SESSION['s_ucid'])) {
		//echo "You have successfully logged in Student!"; 
	}else {
		//redirects to kfront page ...if not logged in
		header("location: kfront.php");
	}
	?>

  <div id="wrapper">

    <div id="topbox">
    <h3>Take a Test</h3>
    <button type="button" onclick="showTestDiv()">Take a Test</button>
    <h3>See Previous results</h3>
    <button type="button" onclick="showGradeDiv()">See current
    grades</button>
 </div>

    <div id="availableTests" style="display:none;">
    <p>List of Tests</p>
    <form method="post" action="/~ka279/cs490/rc/student_take_test.php"> 
       <?php
       foreach(json_decode($tests) as $test){
       	echo "<input type='checkbox' name=testList[]' value='$test'>$test <br>"; //Test - check box
          }
       ?>
           <br> 
       <input type="submit" name="selectedExam" value="Start Testing">
    </form>
     </div>



</center>
</body>
</html>
