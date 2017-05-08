<?php

   //Get filtered questions from database
   $category = $_GET['q'];

   $url="https://web.njit.edu/~em244/CS490/getFilteredQuestions.php?category=$category";
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   $response = curl_exec($ch);
   curl_close($ch);

   echo "<form action='javascript:void%200' onsubmit='selectedQuestions(this)' />";
      foreach (json_decode($response) as $question ){
         echo "<input type='checkbox' name='questionList[]'
            value='$question'> $question <br> <br>";
      }
   echo "<br>
   <button type='submit' class='btn btn-block btn-primary'>Add to test</button>
   </form>";
  
?>