<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Post Results -> Prof Get Student Test -> [Prof get student page]
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
   <meta charset="UTF-8">
   <title>CS490 Prof get Student Test Page</title>
   <link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="student_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>

<body>
<center>
 
    <?php
      $student = $_GET['student'];  
      $_POST['sn'] = $student;
    ?>
<h2><?php echo $student; ?> POV</h2>
</center> 


<?php      
  	 $jsonData = array(
    //'flag' => 'login',
    'studentName' => $_POST['sn']
    );
    
    //MID URL
    //$url = "https://web.njit.edu/~or32/rc/receivetakentests.php";
    $url = "https://web.njit.edu/~em244/CS490/getTakenTests.php";

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
    print_r ($resultz);
    print('</pre>');
    
   ?>



   </body>
</html>
