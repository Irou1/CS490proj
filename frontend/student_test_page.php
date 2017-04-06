<!--
Kenneth Aparicio 
Front End
CS490

Student -> Test Page -> [Actual Test Page] 
 -->

 <?php
//start session
session_start();
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
	    //$exam = 'testhello'; 
       $exam = $_GET['exam'];
	    //$questions = array("one", "two", "three");
	    $examData = array('exam'=>$exam);

	    $url = "https://web.njit.edu/~em244/CS490/Model/getTestQuestions.php";
	    $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $questions = curl_exec($ch);
            curl_close($ch);
            
         ?>
         <h2>Currently taking test:  <?php echo $exam; ?></h2>
         <form method="post" action="submitTest.php"> 
	    <br>
	    <?php
               foreach(json_decode($questions) as $question){
      		       echo "<h4>$question</h4>"; 
                 ?>
    
         <textarea id="studentAnsInput" class ="input" rows="7" cols="60" placeholder="Enter your answer here" name="studentAnsInput"> </textarea>
			<br>
			
			<br>
         <?php 
	       }   
	       ?>
	    <br>
       <br>
            <input type="submit" value="Submit Test for Grading" class="btn btn-hover btn-block btn-primary">
         </form>
      </div>
   </center>  
   </body>
</html>
