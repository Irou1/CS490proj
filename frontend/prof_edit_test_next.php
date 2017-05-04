<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Manage Test -> Edit Test -> [Actual Test] 
 -->

 <?php
//show errors
include 'showerrors.php';
 
//start session
session_start();
include 'profSession.php';
 ?>


  <?php

  //GET all current test's questions
  $exam = $_GET['exam'];  //$exam = 'someTest'; 
  $_SESSION['examName'] = $_GET['exam']; 
  
  $examData = array('exam'=>$exam);  //$questions = array("one", "two", "three");

  //$url = "https://web.njit.edu/~or32/xr/receiveonetest.php";
  $url = "http://afsaccess2.njit.edu/~or32/xr/receiveonetest.php";

  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $questions = curl_exec($ch);
        curl_close($ch);
  ?>
  

  <?php
  
  if (isset($_POST['delTestButton'])) 
  { 

  //if ($_GET['delTestButton']){
    deleteTestFunction();
    //echo $_SESSION['examName'];
    //header('Location: http://web.njit.edu/~ka279/cs490/final/prof_home.php');    
    header('Location: http://afsaccess2.njit.edu/~ka279/cs490/final/prof_home.php');    
  }

    function deleteTestFunction() {
      //echo 'Run php function!';
      //

        //JSON data
    $jsonData = array(
    //'exam' => $removeExam
    'exam' => $_SESSION['examName']

    );
    
    //MID URL

    // $url = "https://web.njit.edu/~or32/xr/deletetest.php";
    $url = "http://afsaccess2.njit.edu/~or32/xr/deletetest.php";

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

    echo $result;

    }

  ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>CS490 Prof Edit Test Page</title>
   <link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<body>

<center>


      <div>

         <h2>Currently editing test:  <?php echo $exam; ?></h2>

          <form method="post">
           <button class="btn btn-block btn-red-primary" name="delTestButton" />Delete Test</button> <!-- testing delete test -->
          </form>

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
          
			<br>
			<br>
         <?php 
	       }   //curly - foreach...

	       ?>
	    <br>
       <br>
            <!-- <input type="submit" name="submit_student_answers_button" value="Submit Test" class="btn btn-hover btn-block btn-red-primary">
            -->
         </form>
      </div>

   </center>  




   </body>
</html>
