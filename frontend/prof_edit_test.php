<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Manage Test -> [Edit Test] 
 -->

 <?php

 //show errors
include 'showerrors.php';

//start session
session_start();
 ?>



<!DOCTYPE html>
<html lang="en">
<head>
	<title>CS490 Prof Edit Test Page Redirecting</title>
</head>

<body>

<?php

   //redirect to test page
   $selectedExam = $_POST['testList'][0];

  
   if($selectedExam){ 
      header("Location: https://web.njit.edu/~ka279/cs490/rc/prof_test_page.php?exam=$selectedExam");
      exit;
   }else{
      echo "Unable to Load test";
   }

?>


</body>
</html>