<!--
Kenneth Aparicio 
Front End
CS490

Student -> Test Page -> click submit test

Send to Middle
1) Student Name
2) Exam Name
3) Student Answers (in array)
 -->

<?php
//start session
session_start();
?>

<?php
//if (isset($_POST['submit_student_answers_button'])) {

	//JSON data
	$jsonData = array(
	'sName' => $_SESSION['s_ucid'],
	'testName' => $_SESSION['examName']

	);

	//Student Answers
	$x=0;
	foreach($_POST['studentAnsInput'] as $value){

		$jsonData[$x] = $value;		 //BEST
		$x++;
	}
	
	//print_r($jsonData); 		//Testing - printing all jsonData****
    //echo "<br>";

	//MID URL
	$url = "https://web.njit.edu/~or32/rc/sendstudentanswers.php";
	//$url = "https://web.njit.edu/~em244/CS490/Model/getGradedAnswers.php";

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
	
	//echo gettype ( $result );		//get var type 

	echo $result; 				//testing - echo middle 

	$resultz = json_decode($result, 1);	//json decode

	//display resultz - json array
	/*print('<pre>');
	print_r ($resultz);
	print('</pre>');
	*/


//} 

?>