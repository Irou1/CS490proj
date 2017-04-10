<!--
Kenneth Aparicio 
Front End
CS490

Student -> Home -> View Old Test -> [old test page]
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
   <title>CS490 Student Old Test Page</title>
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

	    //GET all current old test's questions
      $oldexam = $_GET['oldexam'];  //$exam = 'someTest'; 
      $_SESSION['oldexamname'] = $_GET['oldexam']; 
      

            
    ?>


         <h2>Currently viewing test:  <?php echo $oldexam; ?></h2>

      </div>

   </center>  



   </body>
</html>
