
function filterQuestions(str){
   
   if(str == ""){
      document.getElementById("list").innerHTML = ""; //getElementByName
      return;
   }else{
      
      if(window.XMLHttpRequest){
         //new browsers
         xmlhttp = new XMLHttpRequest();
      }else{
         //old browsers
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function(){
         if(this.readyState == 4 && this.status == 200){
            document.getElementById("list").innerHTML = this.responseText;
	 }
      };
      xmlhttp.open("GET","filteredQuestions.php?q="+str, true);
      xmlhttp.send();
   }

}

function selectedQuestions(questionList){
   for(var x=0; x<questionList.length; x++){
      if(questionList[x].checked){
         console.log(questionList[x].value);
         var current = document.getElementById('selected');
         var input = document.createElement("div");
         //input.id = 'tests'; 
         input.innerHTML = "<input type='checkbox' name='submitList[]' value='"+questionList[x].value+"'>"+questionList[x].value+" <br><input type='number' min='1' style='width: 60px' name='pointsAssigned[]' placeholder='Pts' maxlength='2' size='1'><br>";
         current.appendChild(input);
      }
   }
}
