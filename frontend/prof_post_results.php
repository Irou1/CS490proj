<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> [Post Results] 

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
	<title>CS490 Prof Logged In</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>	

<?php
	//MID URL - get Student Names
	//$url = "https://web.njit.edu/~or32/rc/receiveallstudents.php";
	$url = "https://web.njit.edu/~em244/CS490/getAllStudents.php";

	//initiate cURL
	$ch = curl_init($url);
	
	//returns $url stuff
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	 //Execute the request
	$result = curl_exec($ch);
	
	//close cURL 
	curl_close($ch);
	
	//echo gettype ( $result );		//get var type 

	$students = json_decode($result, 1);	//json decode

	echo "<pre>";
	print_r($students);
	echo "</pre>";
?>

<script type="text/javascript">

function showStudentsDiv(){
   document.getElementById('studentDivSpace').style.display = "block";
}	


</script>

</head>

<body>
<center>
<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
<h1>List of students which took a test</h1>
     
<div id="wrapper">

    <div id="topbox">
    <button type="button" class="btn btn-hover btn-block btn-primary" onclick="showStudentsDiv()">Show Students</button>
 	</div>

    <div id="studentDivSpace" style="display:none;">
    
    <form method="post" action="prof_get_sTest.php"> 
    	<h3>List of Students</h3>
       <?php
       foreach($students["username"] as $s){

       	echo "<p>";
       	echo "<input type='radio' name=studentList[]' value='$s'>"; //Test - radio button
       	echo "<font color=DarkBlue>$s</font>";
       	echo "</p>";
          }
       ?>         
        <br> 
       <input type="submit" class="btn btn-hover btn-block btn-orange-primary" name="selectedStudent" value="Get Student Tests">
    </form>
 </div>




</center>
</body>
</html>
