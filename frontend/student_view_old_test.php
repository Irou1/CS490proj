<!--
Kenneth Aparicio 
Front End
CS490

Student -> Home -> [View Old Test] -> 
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
	<title>CS490 Student Old Test Page Redirecting</title>
</head>

<body>

<?php

   //redirect to test page
   $selectedOldExam = $_POST['oldTestList'][0];

  
   if($selectedExam){ 
      header("Location: https://web.njit.edu/~ka279/cs490/rc/student_old_test_page.php?oldexam=$selectedOldExam");
      exit;
   }else{
      echo "Unable to Load test";
   }

?>


</body>
</html>