<!--
Kenneth Aparicio 
Front End
CS490

Student -> Home -> Take Test -> [Test Page] 
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
   <title>CS490 Student Test Page</title>
   <link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<body>
<center>
      <div>
      <?php

	    //GET all current test's questions
      $exam = $_GET['exam'];  //$exam = 'someTest'; 
      $_SESSION['examName'] = $_GET['exam']; 
      
	    $examData = array('exam'=>$exam);  //$questions = array("one", "two", "three");

      $url = "https://web.njit.edu/~or32/rc/receiveonetest.php";
	  
      $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $questions = curl_exec($ch);
            curl_close($ch);
            
         ?>


         <h2>Currently taking test:  <?php echo $exam; ?></h2>
         <form method="post" action="student_submit_action.php"> 
	    <br>
	    <?php 

                $i=1;
                $studentAnsArr = array(); //testing
               foreach(json_decode($questions) as $question){
                 echo "<h2>Question $i</h2>";
      		       echo "<h4>$question</h4>"; 

                 $i = $i + 1;
                 
      ?>
    
        <textarea id="studentAnsInput" class ="input" placeholder="Enter your answer here" rows="7" cols="60"  name="studentAnsInput['<?php echo $question; ?>']"></textarea>
        <?php 

        ?>
             
			<br>
			
			<br>
         <?php 
	       }   //curly - foreach...

	       ?>
	    <br>
       <br>
            <input type="submit" name="submit_student_answers_button" value="Submit Test" class="btn btn-hover btn-block btn-red-primary">
         </form>
      </div>

   </center>  



   </body>
</html>
