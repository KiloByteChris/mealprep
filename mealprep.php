<!DOCTYPE HTML>
<html lang="en">
<?php
if(!isset($_SESSION)){
	session_start();
	$_SESSION['user_name'] = "CHRIS";
	var_dump($_SESSION);
}

var_dump($_POST);
?>

<head>

	<meta charset="utf-8" >
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- JQUERY -->
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
	<!-- JQUERY UI -->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<!-- CSS -->
	<link rel="stylesheet" href="css/mealprep.css">
	
	<title>mealprep</title>
	
</head>

<body>

<div id="wrapper">

	<header>
	
		<h1>Meal Prep</h1>
		
		<nav>
			<a href="newrecipe.html">New Recipe</a>
			<a href="browse_recipes.php">Browse Recipes</a>
			<a href="saved_plans.php">Saved Meal Plans</a>
		</nav>
		
	</header>
	
	<content>
	
		<!-- form for choosing the days of the week -->
		<div id="chooseDaysDiv">
		</div>
		
		<!-- form for meal prep calander -->
		<div id="calanderDiv">
		</div>
	
	
		<!-- Search Box -->
		<form id="searchForm" action="" method="GET">
			<fieldset>
			<legend>Search Recipes</legend>
				<label for="typeSelect">Select Search Type: </label>
				<select name="typeSelect">
					<option value="*"></option>
					<option value="recipe_name">Recipe Name</option>
					<option value="ingredient_name">Ingredient</option>
					<option value="tag">Tag</option>
				</select>
				<label for="catagorySelect">Select Meal Type: </label>
				<select name="catagorySelect">
					<option value=""></option>
					<option value="breakfast">Breakfast</option>
					<option value="lunch">Lunch</option>
					<option value="dinner">Dinner</option>
				</select>
				<label for="searchBox"></label>
				<input type="text" name="searchBox" maxlength="50">
				<input type="submit" value="Search" name="search">
			</fieldset>
		</form>

		<!-- Display Recipes -->
		<div id="displayRecipesDiv">
		</div>
	
	</content>
	
</div><!-- end wrapper -->

<script>
	//Javascript for choosing the days and generating the calander
	
	function Calander() {
	
		//creates the html for each calander day
		this.day = function(day) {
			
			var dayLower = day.toLowerCase()
			var breakfastLabel = dayLower + "Breakfast";
			var lunchLabel = dayLower + "Lunch";
			var dinnerLabel = dayLower + "Dinner";
			
			var dayString = "";
			dayString += "<div>";
			dayString += "<fieldset class=\"dayField\">";
			dayString += "<legend>" + day + "</legend>";
			
			dayString += "<label for=" + breakfastLabel + ">Breakfast</label>";
			dayString += "<input type=\"text\" name=" + breakfastLabel + " value=\"\" class=\"recipeInput\" maxlength=\"50\">";
			
			dayString += "<label for=" + lunchLabel + ">Lunch</label>";
			dayString += "<input type=\"text\" name=" + lunchLabel + " value=\"\" class=\"recipeInput\" maxlength=\"50\">";
			
			dayString += "<label for=" + dinnerLabel + ">Dinner</label>";
			dayString += "<input type=\"text\" name=" + dinnerLabel + " value=\"\" class=\"recipeInput\" maxlength=\"50\">";
			
			dayString += "</fieldset>";
			dayString += "</div>"; 
			return dayString;
		}
	
		//updates the calander based on the input from the form
		this.update = function(calanderDiv, checkBoxes) {
			//select the div where the calander is going to be once it's generated
			var calanderDiv = document.getElementById("calanderDiv");
			calanderDiv.innerHTML = "";
			//Select the checkboxes to see if their value is equa to "checked"
			var checkBoxes = document.getElementsByClassName("checkbox");
			var dayList = [];
			for(var i = 0; i < checkBoxes.length; i++) {
				if(checkBoxes[i].checked == true){
				dayList.push(checkBoxes[i]);
				}
			}
			
			for(var i = 0; i<dayList.length; i++) {
				
				dayStuff = weekForm.day(dayList[i].value);
				calanderDiv.innerHTML += dayStuff;
			}
		}
	}
	
	//a list of the days of the week
	var fullList = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; 
	var chooseDaysDiv = document.getElementById("chooseDaysDiv");
	
	//function creates the form with check boxes for selecting which days of the week
	function chooseDays(fullList) {
		var chooseDaysString = "";
		chooseDaysString += "<div id=\"chooseDaysFormDiv\">";
		chooseDaysString += "<form id=\"chooseDaysForm\" action=\"\" method=\"POST\">";
		
		for(var i = 0; i < fullList.length; i++){
			var day = fullList[i];
			var dayLabel = day + "box";
			
			
			chooseDaysString += "<label for=" + dayLabel +">" + day + "</label>";
			chooseDaysString += "<input type=\"checkbox\" class=\"checkbox\" value=" + day + " name=" + dayLabel + ">";	
			
		}
		
		//Select box for choosing the number of servings
		chooseDaysString += "<label for=\"servingsSelect\">Number of Servings</label>";
		chooseDaysString += "<select name=\"servingSelect\" id=\"servingSelect\">";
		for(var i = 1; i <= 10; i++){
			chooseDaysString += "<option value="+ i +">" + i + "</option>";
		}
		
		chooseDaysString += "</select>";
		chooseDaysString += "<button type=\"button\" id=\"daysButton\" onclick=\"weekForm.update()\">Create Calander</button>";
		chooseDaysString += "</div>";
		chooseDaysString += "</form>";
		return chooseDaysString;
	}
	
	//uses the list of days to generate a form with checkboxese for each day
	var chooseDaysFormString = chooseDays(fullList);
	chooseDaysDiv.innerHTML += chooseDaysFormString;
	
	
	//Create a new calander
	var weekForm =  new Calander();
	
	$("recipeInput").addClass("droppable");
	
	$( function() {
		$( ".draggable" ).draggable({
			cursor : 'pointer',
			revert : true,
			revertDuration : 250,
			start: function( event, ui ) {
				$dropText = $(this).text();
			}
		});
		$(".droppable").droppable({
			activeClass : 'highlight',
			tolerance : 'pointer',
			drop : function(event, ui) {
				$(this).val($dropText);
				
			}
		});	
	} );
</script>
</body>
</html>