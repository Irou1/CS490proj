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
	//MID URL - get Test Names so student can TAKE it
	$url = "https://web.njit.edu/~or32/rc/receivealltests.php";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tests = curl_exec($ch);
  curl_close($ch);
?>

<body>
<center>
	<font color="white" size="6" face="verdana">Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </font><br><br>
	<!-- <h1>Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </h1> -->
	

  <?php //---------Student take a test-------------------?>
  <div id="wrapper">

    <div id="topbox">
    <!-- <font color="white" size="3" face="verdana">Take a Test:</font><br> -->
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
       	echo "<input type='radio' name='testList[]' value='$test' required>"; //Test - radio button
       	echo "<font color=white>$test</font>";
       	echo "</p>";
          }
       ?>         
        <br> 
       <input type="submit" class="btn btn-hover btn-block btn-green-primary" name="selectedExam" value="Start Testing">
    </form>
    </div>



    <?php 
    //------Student check grade, he/she took--------------WORKING ON IT--------------
   
  
    //JSON data
    $jsonData = array(
    'studentName' => $_SESSION['s_ucid']
    );

    //print_r($jsonData);     //Testing - printing all jsonData****
      //echo "<br>";
    
    //MID URL - get Test Names that student ALREADY TOOK
    //$url = "https://web.njit.edu/~or32/rc/receiveexamsstudenttook.php";
    $url = "https://web.njit.edu/~em244/CS490/getAvailableTests.php";

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
    
    //echo gettype ( $result );   //get var type 

    //echo $result;         //testing - echo middle 

    $studentOldTests = json_decode($result, 1); //json decode

    //display resultz - json array
    //print('<pre>');
    //print_r ($studentOldTests);
    //print('</pre>');  

    //-------testing-----

  ?>

  <?php //---------Student old test - see Grade-------- ?>
  
  <div id="wrapper">

    <div id="topbox">
    <br>
    <br>
    <font color="white" size="3" face="verdana">Show Tests I Took:</font><br>
    <button type="button" class="btn btn-hover btn-block btn-primary" onclick="showOldTestDiv()">See current grades</button>  
    <br>
    </div>

 </div> <!-- wrapper end div -->

    <div id="showOldTestDiv" style="display:none;"> <!-- hidden -->
    
    <form method="post" action="/~ka279/cs490/rc/student_see_old_test_and_grade.php"> 
      <font color="white" size="3" face="verdana">List of Tests:</font>
       <?php
       foreach( $studentOldTests["examName"] as $oldtest){
        //echo $test;

        echo "<p>";
        echo "<input type='radio' name='oldTestList[]' value='$oldtest' required>"; //Test - radio button
        echo "<font color=DarkBlue>$oldtest</font>";
        echo "</p>";
          }
        $_SESSION['myOldTest'] = $oldtest;  
       ?>         

        <br> 
       <input type="submit" class="btn btn-hover btn-block btn-orange-primary" name="selectedOldExam" value="View Grade for this Test">
    </form>
    </div>
  
  <br>
  <?php /* //old stuff
    <input type="button" value="View Grade" class="btn btn-hover btn-block btn-orange-primary" onclick="window.location.href='s_view_grade.php'" />
    */
  ?>


</center> 
</body>
</html>
