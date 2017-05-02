<!--
Kenneth Aparicio 
Front End
CS490

Student -> Home -> [View Old Test + Feed Back] 
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
	<title>CS490 Student See Test Grade</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="studentscript.js"></script>
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>
<body>
  <center>
	<font color="white" size="6" face="verdana">Welcome <?php echo ucfirst($_SESSION['s_ucid']) ?> </font><br>
	<font color="white" size="6" face="verdana"> Viewing Graded Exam: <?php echo ucfirst($_SESSION['myOldTest']) ?> </font><br><br>
	</center>

  <?php
  
  //JSON data
  $jsonData = array(
  //'flag' => 'login',
  'studentName' => $_SESSION['s_ucid']
  );
  
  //MID URL
  $url = "https://web.njit.edu/~or32/rc/getgrade.php";
  //$url = "https://web.njit.edu/~em244/CS490/getFirstGrade.php";

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

  $resultz = json_decode($result, 1); //json decode

  $feedback = json_decode($resultz["grievances"], 1);

  //display resultz - json array
  print('<pre>');
  ?>
  
  <h3>
  <?php print_r ($resultz); ?>  
  <?php print_r ($feedback); ?>	
  </h3>

  <?php
  print('</pre>');

 ?>
  
<?php //----------------------------------------------------------------------------------------testing ?>

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
  $sAns = array("answer1", "answer2", "answer3", "answer4");
  foreach ($sAns as $sa) {
    echo "<font color='white' size='3' face='verdana'>Your Answer</font>" . "<br>";
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

  <textarea type="text" readonly class="f" rows="7" cols="36" style="resize:none;" ><?php echo $f; ?></textarea>
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

  <input type="text" readonly class="p" style="width: 60px" value="<?php echo $pts . '/' . '10' . 'pts'; ?>" maxlength="10" size="1">
  <br><br><br><br><br><br><br><br>

  <?php
  } // for each POINTS- ending curly brace
  ?>
  </div>  

</div>




</body>
</html>