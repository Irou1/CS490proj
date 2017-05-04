<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Post Results -> Prof Get Student Test -> Prof get student Test page -> [Prof Publish Test Score]
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
	<title>CS490 Prof Publish Student Test Score Redirecting</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>	



<center>
<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
<h1>Thank You for grading <?php echo ucfirst($_SESSION['studentName']) ?> </h1>
</center>

<?php

   $selectedStudentTest = $_POST['testNameList'][0];
 
   //echo $selectedStudentTest;
   //echo "<br>";

?>

<?php

	//JSON data
	$jsonData = array(
	'studentName' => $_SESSION['studentName'],
	'examName' => $selectedStudentTest
	//'flag' => 1

	);


	//print_r($jsonData); 		//Testing - printing all jsonData****
    //echo "<br>";
	
	
	//MID URL
	$url = "https://web.njit.edu/~or32/rc/changeviewflag.php";
	//$url = "https://web.njit.edu/~em244/CS490/changeExamStatus.php";

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

	//echo $result; 				//testing - echo middle 

	$resultz = json_decode($result, 1);	//json decode

	//display resultz - json array
	//print('<pre>');
	//print_r ($resultz);
	//print('</pre>');
	

?>
</head>

<body>
<?php //--------------testing ----showing student's test ---edit feedback and edit points ?>

<div class ="master">

  <div class="col">
  <?php
  $i=1;
  $t_questions = array ("q1", "q2", "q3", "q4");

  //echo "Test Questions are: " . $t_questions[0] . " " . $t_questions[1] . " " . $t_questions[2] . " " . $t_questions[3] ;

  foreach ($t_questions as $tq){
    echo "<font color='white' size='3' face='verdana'>Question $i</font>" . "<br>";
    //echo $tq . "<br>";

  ?>
  <textarea type="text" readonly class="question" name="q" rows="7" cols="36" style="resize:none;" ><?php echo $tq; ?></textarea>
  <br>
  <br>

  <?php 
  $i=$i+1;

  } // for each TESTquestion- ending curly brace
  ?>  
  </diV>

  <div class="col">
  <?php
  $sn = ucfirst($_SESSION['studentName']);

  $sAns = array("answer1", "answer2", "answer3", "answer4");
  foreach ($sAns as $sa) {
    echo "<font color='white' size='3' face='verdana'>$sn's Answer </font>" . "<br>";
  ?>

  <textarea type="text" readonly class="answer" name="a" rows="7" cols="36" style="resize:none;" ><?php echo $sa; ?></textarea>
  <br>
  <br>

  <?php
  } // for each STUDENTanswer- ending curly brace
  ?>
  </div>

  <div class="col">
  <?php
  $feedback = array("good", "bad", "compiling errors", "works");


  foreach ($feedback as $f) {
    echo "<font color='white' size='3' face='verdana'>Feedback</font>" . "<br>";

  ?>

  <textarea type="text" class="f" rows="7" cols="36" style="resize:none;" ><?php echo $f; ?></textarea>
  <br>
  <br>

  <?php
  } // for each FEEDBACK- ending curly brace
  ?>
  </div>

  <div class="col">
  <?php
  echo "<font color='white' size='3' face='verdana'>Earned</font>" . "<br>" . "<br>" . "<br>" . "<br>" . "<br>" . "<br>";


  $oldTest = array(
     'points' => '66', '20', '50', '5',
     'us' => 'United States'
  );
  
  $points = array("10", "20", "50", "500");
  foreach ($points as $pts){ 
    
  ?>
  <?php /*
  <textarea type="points" readonly class="p" min="0" maxlength="2" rows="1" cols="5" style="resize:none;" ><?php echo $pts . 'pts'; ?></textarea>

  <input type="number" min="0" style="width: 60px" placeholder="Pts" maxlength="2" size="1">
  */
  ?>

  <input type="number" min="0" class="p" style="width: 60px" value="<?php echo $pts; ?>" maxlength="2" size="1">
  <br><br><br><br><br><br><br><br>

  <?php
  } // for each POINTS- ending curly brace
  ?>
  </div>  

</div>  




</body>
</html>