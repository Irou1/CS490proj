<?php

   //show errors
   include 'showerrors.php';
   //start session
   session_start();
   include 'profSession.php';

?>

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>CS490 Prof Logged In</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <ul>
      <li><a class="active" href="prof_home.php">Home</a></li>
      <li style="float:right"><a href="logout.php">LogOut</a></li>
    </ul>
  </head>

  <body>
    <script src="script.js"></script>
    
    <?php
       //create Test and run function to do so
       if(isset($_POST['create_test'])){
          createTest();
          $_SESSION['message'] = "Test Created!";
          echo "<div id='blue_msg'>".$_SESSION['message']."</div>";
          unset($_SESSION['message']);
       }
    ?>

      <center>
        <font color="white" size="6" face="verdana">Welcome <?php echo ucfirst($_SESSION['p_ucid']) ?> </font><br>
	<font color="white" size="6" face="verdana">Create Test</font></br>
      </center>

      <div id="left">
      <br><br>
        <font color="white" size="6" face="verdana">Questions Added for new Test</font></br>
        
	<form method="post" action="prof_create_test.php" >
    <br>
	  <input type="text" name="examName" placeholder="Enter a new Test Name" class="textInput" required>
    <br><br>
	  
	  <div id="selected">
	    <!-- selected questions appear here-->
	  </div>
          <br>
	  <input type="submit" name="create_test" value="Create Test" class="btn btn-block btn-primary">
        </form>
	<?php
           function createTest(){  
              if(isset($_POST['examName'])){
           
	         $jsonData = array(
	            'examName'=>$_POST['examName'], 
		    'submitList'=>$_POST['submitList'],
	            'pointsAssigned'=>$_POST['pointsAssigned']
                 );
                 $jsonData = http_build_query($jsonData);
                 $url = "https://web.njit.edu/~em244/CS490/createExam.php";
                 $ch = curl_init($url);
                 curl_setopt($ch, CURLOPT_POST, true);
                 curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 $result = curl_exec($ch);
                 curl_close($ch);

				//display resultz - json array
					print('<pre>');
					print_r ($result);
					print('</pre>');
	
	      }
	   }
           
        ?>
      </div>

      <div id="right">
        <!-- <h1>Select Questions</h1> -->
        <br><br>
        <font color="white" size="6" face="verdana">Select Questions from Question Bank</font></br>

          <?php	

             //To Receive all Questions from question bank
             $url = "https://web.njit.edu/~or32/rc/receivealltasks.php";
             $ch = curl_init($url);	
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             $result = curl_exec($ch);
             curl_close($ch);
             $resultz = json_decode($result, 1);

          ?>	

	  <br>
	  <form>
     <font color="white" size="3" face="verdana">Category:</font>
		<select name="myCategory" onchange="filterQuestions(this.value)">
		  <option value="">Filter</option>
		  <option value="all">All</option>
		  <option value="loop">Loops</option>
		  <option value="method">Methods</option>
		  <option value="relational">Relational</option>
		  <option value="recursive">Recursive</option>		
		</select>
	    <br>
	  </form>
          <!--	
          <font color="white" size="3" face="verdana">Difficulty:</font>
          <select name="myDiff" id="myDiff" required>
            <option value="nada">Please select ...</option>
            <option value="0">Easy</option>
            <option value="1">Medium</option>
            <option value="2">Hard</option>
          </select>
          <br><br>
          -->
          <div id="list">
            <!-- filtered questions appear here -->
          </div><br>
      </div>

  </body>
</html>