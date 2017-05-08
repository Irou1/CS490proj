<!--
Kenneth Aparicio 
Front End
CS490

Prof -> Home -> Post Results -> Prof Get Student Test -> Prof get student Test page -> [Prof Publish Test Score]
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
	<title>CS490 Prof Publish Student Test Score Redirecting</title>
	<link rel="stylesheet" type="text/css" href="style.css">
<ul>
  <li><a class="active" href="prof_home.php">Home</a></li>
  <li style="float:right"><a href="logout.php">LogOut</a></li>
</ul>	



<center>
<h1>Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </h1>
<h1>Thank You for grading <?php echo ucfirst($_SESSION['studentName']) ?> </h1>
</center>

<?php

   $selectedStudentTest = $_POST['testNameList'][0];
   $_SESSION['studentOldExam'] = $selectedStudentTest;

    echo "yooo";
    echo $_SESSION['studentOldExam'];
   //echo $selectedStudentTest;
   //echo "<br>";
?>

    <?php

      //GET all current test's questions
     
        $examData = array(
            'student' => $_SESSION['studentName'],
            'exam' => $selectedStudentTest
              );

      //$url = "https://web.njit.edu/~or32/xr/receiveonetest.php";
      $url = "http://afsaccess2.njit.edu/~or32/xr/receiveonetest.php";
      
    
      $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $questions = curl_exec($ch);
            curl_close($ch);

            $t_questions = json_decode($questions) 
            
      ?>

      <?php

      //GET all student ANSWERS
     
        $examData = array(
            'student' => $_SESSION['studentName'],
            'exam' => $selectedStudentTest
              );

      //$url = "https://web.njit.edu/~or32/xr/receiveonetest.php";
      $url = "http://afsaccess2.njit.edu/~or32/xr/getanswers.php";
      
    
      $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $ans = curl_exec($ch);
            curl_close($ch);
            $ans2 = json_decode($ans, 1); //json decode
            

          $ans3 = trim($ans2[0],'[""]');
          $answer= explode('","',$ans3);

          echo "student answers:"; 
          echo "<br>";
          print('<pre>');
          print_r ($answer);
          print('</pre>');

      ?>



  <?php
  //CURL ---->FEEDBACK + Final Grade

  //JSON data
  $jsonData = array(
  //'flag' => 'login',
  'studentName' => $_SESSION['studentName'],
  'exam' => $selectedStudentTest

  );
  
  //MID URL

  //$url = "https://web.njit.edu/~or32/xr/getgrade.php";
  //$url = "https://web.njit.edu/~em244/CS490/getFirstGrade.php";
  $url = "http://afsaccess2.njit.edu/~or32/xr/getgrade.php";
  

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

  $myGrade = json_decode($resultz["grade"], 1); //Total Grade

  $feedback = json_decode($resultz["grievances"], 1);  //array

  //display resultz - json array
  print('<pre>');
  ?>
  
  <h3>
  <?php print_r ($resultz); ?>  
  <?php print_r ($feedback); ?> 
  </h3>

  <?php
  print('</pre>');
 ?>

  <?php
  //GET all current test's ---> QUESTION POINTS from Test
  
  $examData = array('exam'=>$selectedStudentTest); 

  $url = "http://afsaccess2.njit.edu/~or32/xr/getexampoints.php";
  
  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $examData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $qp = curl_exec($ch);
        $qPoints = json_decode($qp);
        curl_close($ch);
   
        //display qPoints - json array
        echo "question points:"; 
        echo "<br>";
        print('<pre>');
        print_r ($qPoints);
        print('</pre>');
        
        
  ?>

  <?php
  //GET STUDENT current test's question's ---> POINTS EARNED
  
  $myData = array(
  'student' => $_SESSION['studentName'],
  'exam' => $selectedStudentTest
  );

  $url = "http://afsaccess2.njit.edu/~or32/xr/getpointsearned.php";
  //$url = "http://afsaccess2.njit.edu/~em244/CS490/getPointsEarned.php";

  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $myData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $qpEarned = curl_exec($ch);
        $qPointsEarned = json_decode($qpEarned);
        curl_close($ch);
   
        //display qPoints - json array
        echo "question points earned in one index: "; 
        echo "<br>";
        print('<pre>');
        print_r ($qPointsEarned);
        print('</pre>');
        
        //display earned question points in array
        $ptsEarned = explode(",",$qPointsEarned[0]); //explode by comma
        echo "question points earned:"; 
        echo "<br>";
        print('<pre>');
        print_r ($ptsEarned);
        print('</pre>');

  ?>

<?php //testing this-------------------------------------------------------------------check ?>
<center>
  <font color="white" size="6" face="verdana">Editing <?php echo ucfirst($_SESSION['studentName']) ?>'s Test </font><br>
  <font color="white" size="6" face="verdana"> Viewing Graded Exam: <?php echo ucfirst($selectedStudentTest) ?> </font><br><br>
  <font color="white" size="6" face="verdana"> Your Grade: <?php echo $myGrade ?> </font><br><br> 

</center>


<div class ="master">
  
  <div class="col">
  
  <?php
  $i=1;
  //$t_questions = array ("q1", "q2");

  //echo "Test Questions are: " . $t_questions[0] . " " . $t_questions[1] . " " . $t_questions[2] . " " . $t_questions[3] ;
  
  foreach ($t_questions as $tq){
    echo "<font color='white' size='3' face='verdana'>Question $i</font>" . "<br>";
    //echo $tq . "<br>";

  ?>
  <textarea type="text" readonly class="question" name="q" rows="7" cols="36" style="resize:none;" ><?php echo $tq; ?></textarea>
  <br>
  <br>

  <?php 
  $i=$i+1;

  } // for each TESTquestion- ending curly brace
  ?>  
  </diV>

  <div class="col">
  
  <?php
  $sAns = array("answer1", "answer2");
  foreach ($answer as $sa) {
    echo "<font color='white' size='3' face='verdana'>Your Answer</font>" . "<br>";
  ?>

  <textarea type="text" readonly class="answer" name="a" rows="7" cols="36" style="resize:none;" ><?php echo $sa; ?></textarea>
  <br>
  <br>

  <?php
  } // for each STUDENTanswer- ending curly brace
  ?>
  </div>

  <div class="col">
  <?php
  $feedbackString = ""; //initliaze feedbackString
  $temp = "";

   $x=0;
  //$feedbackStuff = array("good", "bad", "ehh", "lol"); //testing

    foreach ($feedback as $ff => $innerArray) {
      foreach (array_slice($innerArray, 0, count($innerArray) - 3) as $realFF => $f) {
      //foreach ($innerArray as $realFF => $f) {
        if (!is_array($f)){ //checks to see if index is an array if its not do this...
          $feedbackString = $feedbackString . $f . "\r\n";
          //$feedbackString = implode("\n", $innerArray);
        } 
      }
  ?>

   
  
  <form method="post" action="">  
     <?php
    
    echo "<font color='white' size='3' face='verdana'>Feedback ";

    echo "<font color='white' size='3' face='verdana'>& Earned";
    // echo "<font color='red' size='3' face='verdana'> Points Earned: $ptsEarned[$x]/$qPoints[$x] </font>" . "<br>";  
    ?>
    <input type="number" min="0" name="newPoints[]" class="p" style="width: 60px" value="<?php echo $ptsEarned[$x]; ?>" maxlength="2" size="1">/<?php echo $qPoints[$x]; ?>
    <!-- <input type="number" min="0" class="p" style="width: 60px" value="<?php echo $qPoints[$x]; ?>" maxlength="2" size="1"> -->

    


  <textarea type="text" readonly class="f" rows="7" cols="41" style="resize:none;" ><?php echo $feedbackString; ?></textarea>
  <br>
  <br>

  <?php
  $feedbackString = "";  //empty the feedbackString
  $x = $x + 1;
  } // for each FEEDBACK- ending curly brace
  ?>
  <center>
      <button type="submit" name="regradeButton" class="btn btn-block btn-primary" >Save Changes</button>
  </center>
  </form>

  </div>
</div>

</body>
<?php 
$newPts="";
if (isset($_POST['regradeButton'])) {
    reGrade();

    header('Location: http://afsaccess2.njit.edu/~ka279/cs490/final/prof_home.php');      
}

function reGrade() {


    foreach ($newPoints as $np){
        $newPts = $newPts . $np . ',';
    } 
    $newPts = trim($newPts, ',');
    //echo $newPts; 


  //JSON data
  $jsonData = array(
  'student' => $_SESSION['studentName'],
  'exam' => $_SESSION['studentOldExam'],
  'points' => $newPts
  );
  
  //MID URL

  $url = "http://afsaccess2.njit.edu/~or32/xr/setpointsearned.php";

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

  //$resultz = json_decode($result, 1); //json decode

}

?>  

</html>