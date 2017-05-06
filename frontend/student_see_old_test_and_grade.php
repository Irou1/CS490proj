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
      <?php

      //GET all current test's questions
     
        $examData = array(
            'student' => $_SESSION['s_ucid'],
            'exam' => $_SESSION['myOldTest']
  );

      //$url = "https://web.njit.edu/~or32/xr/receiveonetest.php";
      $url = "http://afsaccess2.njit.edu/~or32/xr/receiveonetest.php";
      
    
      $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $questions = curl_exec($ch);
            curl_close($ch);

            $t_questions = json_decode($questions) 
            
      ?>




  <?php
  //CURL ---->FEEDBACK + Final Grade

  //JSON data
  $jsonData = array(
  //'flag' => 'login',
  'studentName' => $_SESSION['s_ucid']
  );
  
  //MID URL

  //$url = "https://web.njit.edu/~or32/xr/getgrade.php";
  //$url = "https://web.njit.edu/~em244/CS490/getFirstGrade.php";
  $url = "http://afsaccess2.njit.edu/~or32/xr/getgrade.php";
  

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

  $myGrade = json_decode($resultz["grade"], 1); //Total Grade

  $feedback = json_decode($resultz["grievances"], 1);  //array

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

  <?php
  //GET all current test's ---> QUESTION POINTS from Test
  
  $examData = array('exam'=>$_SESSION['myOldTest']); 

  $url = "http://afsaccess2.njit.edu/~or32/xr/getexampoints.php";
  
  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $qp = curl_exec($ch);
        $qPoints = json_decode($qp);
        curl_close($ch);
   
        //display qPoints - json array
        echo "question points:"; 
        echo "<br>";
        print('<pre>');
        print_r ($qPoints);
        print('</pre>');
        
        
  ?>

  <?php
  //GET STUDENT current test's question's ---> POINTS EARNED
  
  $myData = array(
  'student' => $_SESSION['s_ucid'],
  'exam' => $_SESSION['myOldTest']
  );

  //$url = "http://afsaccess2.njit.edu/~or32/xr/getpointsearned.php";
  $url = "http://afsaccess2.njit.edu/~em244/CS490/getPointsEarned.php";

  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $qpEarned = curl_exec($ch);
        $qPointsEarned = json_decode($qpEarned);
        curl_close($ch);
   
        //display qPoints - json array
        echo "question points earned:"; 
        echo "<br>";
        print('<pre>');
        print_r ($qPointsEarned);
        print('</pre>');
        
        
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
  <!-- <font color="white" size="6" face="verdana"> Your Grade: <?php echo $myGrade ?> </font><br><br> -->

    <?php
      //echo "<font color='white' size='6' face='verdana'>Your Grade:";
    if ($myGrade < 70){
        echo "<font color='red' size='6' face='verdana'> Your Grade: $myGrade</font>" . "<br>" . "<br>";  
    }else{
      echo "<font color='green' size='6' face='verdana'> Your Grade: $myGrade </font>" . "<br>" . "<br>"; 
    }
  ?>
	</center>


<div class ="master">

  <div class="col">
  <?php
  $i=1;
  //$t_questions = array ("q1", "q2");

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
  $sAns = array("answer1", "answer2");
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
  $feedbackString = ""; //initliaze feedbackString
  $temp = "";
   $points = array("2", "35");
   $totalPoints = array("35", "50");
   $x=0;
  //$feedbackStuff = array("good", "bad", "ehh", "lol"); //testing

    foreach ($feedback as $ff => $innerArray) {
      //foreach (array_slice($innerArray, 0, count($innerArray) - 1) as $realFF => $f) {
      foreach ($innerArray as $realFF => $f) {
        $feedbackString = $feedbackString . $f . "\r\n";
        //$feedbackString = implode("\n", $innerArray);
      }

   
    echo "<font color='white' size='3' face='verdana'>Feedback ";
    echo "<font color='white' size='3' face='verdana'>&";
    if ($points[$x] < $totalPoints[$x] * 0.7){
        echo "<font color='red' size='3' face='verdana'> Points Earned: $points[$x]/$totalPoints[$x] </font>" . "<br>";  
    }else{
      echo "<font color='green' size='3' face='verdana'> Points Earned: $points[$x]/$totalPoints[$x] </font>" . "<br>"; 
    }
  ?>

  <textarea type="text" readonly class="f" rows="7" cols="41" style="resize:none;" ><?php echo $feedbackString; ?></textarea>
  <br>
  <br>

  <?php
  $feedbackString = "";  //empty the feedbackString
  $x = $x + 1;
  } // for each FEEDBACK- ending curly brace
  ?>
  </div>



</div>




</body>
</html>