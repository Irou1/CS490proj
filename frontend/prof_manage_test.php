<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> [Manage Test] 
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
	<meta charset="UTF-8">
	<title>CS490 Prof Logged In</title>
	<link rel="stylesheet" type="text/css" href="style.css">
  <script src="profscript.js"></script>
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>
</head>


<?php
	//MID URL - get Test Names

	//$url = "https://web.njit.edu/~or32/xr/receivealltests.php";
  $url = "http://afsaccess2.njit.edu/~or32/xr/receivealltests.php";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tests = curl_exec($ch);
  curl_close($ch);
?>

<body>
<center>
	<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>

  <div id="wrapper">

    <div id="topbox">
    <h3>Edit a Test</h3>
    <button type="button" class="btn btn-hover btn-block btn-primary" onclick="showTestDiv()">Choose a Test to Edit</button>
    </div>

 </div> <!-- wrapper end div -->

    <div id="availableTests" style="display:none;">
    
    <form method="post" action="/~ka279/cs490/final/prof_edit_test.php"> 
    	<!-- <h3>List of Tests</h3> -->
    <?php

      if (!empty(json_decode($tests))) {
        echo "<font color='white' size='3' face='verdana'>List of Tests:</font>";
       //foreach( $studentOldTests["examName"] as $oldtest){------
        foreach(json_decode($tests) as $test){
        //echo $test;

        echo "<p>";
        echo "<input type='radio' name=testList[]' value='$test' required>"; //Test - radio button
        echo "<font color=DarkBlue>$test</font>";
        echo "</p>";
          } 
        $_SESSION['myNewTest'] = $test;  
        ?>
       <input type="submit" class="btn btn-hover btn-block btn-orange-primary" name="selectedExam" value="Edit">
        <br>

        <?php
      }
      else{ 
        //echo "<br>" . "<br> " . "<font color='red' size='3' face='verdana'>You have not taken any Tests yet</font>" . "<br>";
        $_SESSION['message'] = "There are NO Test(s) that have been created yet";
        echo "<div id='red_msg'>".$_SESSION['message']."</div>";
        unset($_SESSION['message']);        

      }
       ?>   
    </form>
     </div>
    
    <?php /*
    <h4>See Previous results</h4>
    <button type="button" class="btn btn-hover btn-block btn-green-primary" onclick="showGradeDiv()">See current grades</button>

    */?>


<body>
<center>




</center>
</body>
</html>
