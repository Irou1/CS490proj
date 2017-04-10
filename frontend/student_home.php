<!--
Kenneth Aparicio 
Front End
CS490

Student - [Home]
-->

 <?php
//show errors
include 'showerrors.php';

//start session
session_start();
include 'studentSession.php';

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
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tests = curl_exec($ch);
  curl_close($ch);
?>

<body>
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </h1>
	
  <div id="wrapper">

    <div id="topbox">
    <font color="white" size="3" face="verdana">Take a Test:</font><br>
    <button type="button" class="btn btn-hover btn-block btn-primary" onclick="showTestDiv();">Take a Test</button>
    <br>
    </div>

 </div> <!-- wrapper end div -->

    <div id="availableTests" style="display:none;"> <!-- hidden -->
    
    <form method="post" action="/~ka279/cs490/rc/student_take_test.php"> 
      <font color="white" size="3" face="verdana">List of Tests:</font>
       <?php
       foreach(json_decode($tests) as $test){
       	//echo $test;

       	echo "<p>";
       	echo "<input type='radio' name=testList[]' value='$test' required>"; //Test - radio button
       	echo "<font color=DarkBlue>$test</font>";
       	echo "</p>";
          }
       ?>         
        <br> 
       <input type="submit" class="btn btn-hover btn-block btn-orange-primary" name="selectedExam" value="Start Testing">
    </form>
    </div>

    <?php //-------------------------------------------------------------------------?>
    <font color="white" size="3" face="verdana">See Previous results:</font><br>
    <button type="button" class="btn btn-hover btn-block btn-green-primary" onclick="showGradeDiv()">See current grades</button>




</center> 
</body>
</html>
