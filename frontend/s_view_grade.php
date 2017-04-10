<!--
Kenneth Aparicio 
Front End
CS490

Student - 
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
	<title>CS490 Student Home Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="studentscript.js"></script>
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>
<body>
       <h3>Previous Test Results</h3>
	      <?php

	    //GET all current test's questions

      $sd = $_SESSION['s_ucid'];  //$exam = 'someTest'; 
      //echo $studentName;


      //$url = "https://web.njit.edu/~or32/rc/getgrade.php";
      

  //JSON data
  $jsonData = array(
  //'flag' => 'login',
  'studentName' => $_SESSION['s_ucid']
  );
  
  //MID URL
  $url = "https://web.njit.edu/~em244/CS490/getFirstGrade.php";

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



  //display resultz - json array
  print('<pre>');
  ?>
  
  <h3><?php print_r ($resultz); ?></h3>

  <?php
  print('</pre>');

 ?>
  
 


    

             

	    <br>
       <br>

</body>
</html>