<!--
Kenneth Aparicio 
Front End
CS490

Student -> Home -> [Take Test] 
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
	<title>CS490 Student Test Page Redirecting</title>
</head>

<body>

<?php

   //redirect to test page
   $selectedExam = $_POST['testList'][0];

  
   if($selectedExam){ 
      //header("Location: https://web.njit.edu/~ka279/cs490/final/student_take_test_next1.php?exam=$selectedExam");
   	header("Location: http://afsaccess2.njit.edu/~ka279/cs490/final/student_take_test_next1.php?exam=$selectedExam");

      exit;
   }else{
      echo "Unable to Load test";
   }

?>


</body>
</html>