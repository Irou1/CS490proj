<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Post Results -> [Prof Get Student Test] 
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
	<title>CS490 Prof Get Student Test Page Redirecting</title>
</head>

<body>

<?php

   //redirect to test page
   $selectedStudent = $_POST['studentList'][0];

  
   if($selectedStudent){ 
      //header("Location: https://web.njit.edu/~ka279/cs490/final/prof_post_results_next2_get_sTest_page.php?student=$selectedStudent");
      header("Location: http://afsaccess2.njit.edu/~ka279/cs490/final/prof_post_results_next2_get_sTest_page.php?student=$selectedStudent");

      exit;
   }else{
   	  //header("Location: https://web.njit.edu/~ka279/cs490/final/prof_post_results.php");
      header("Location: http://afsaccess2.njit.edu/~ka279/cs490/final/prof_post_results.php");
        

      //echo "Unable to Load Student's test";
   }

?>


</body>
</html>