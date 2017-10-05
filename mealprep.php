<!DOCTYPE HTML>
<html lang="en">
<?php
if(!isset($_SESSION)){
	session_start();
}

//Initialize the $searchResults variable
$searchResults = "";
//initialize the $calanderString Variable
$calanderString = "";

# mysqli_connect.inc.php

# Create a new connection to the database
$db = new mysqli('localhost','root','','mealprep');

# If there was an error connecting to the database
if ($db->connect_error) {
	$error = $db->connect_error;
	echo $error;
} // end if

# Set the character encoding of the database connection to UTF-8
$db->set_charset('utf8');

//var_dump($_POST);
$fullList = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

//function creates the form with check boxes for selecting which days of the week
function createDayCheckboxes($fullList) {
	$chooseDaysString = "";
	$chooseDaysString .= "<div id=\"chooseDaysDiv\">";

	for($i = 0; $i < count($fullList); $i++){
		$day = $fullList[$i];
		$dayLower = strtolower($day);
		$dayLabel = $dayLower . "Box";

		$chooseDaysString .= "<label for=" . $dayLabel .">" . $day . "</label>";

		//Sets the default value to not be checked
		//If the form has been posted and the box is checked, make it sticky
		$checked = "";
		if(isset($_POST[$dayLabel])){
			$checked = "checked";
		}
		$chooseDaysString .= "<input type=\"checkbox\" class=\"checkbox\" value=" . $day . " name=" . $dayLabel . " $checked>";

	}

	//Select box for choosing the number of servings
	$chooseDaysString .= "<label for=\"servingsSelect\">Number of Servings</label>";
	$chooseDaysString .= "<select name=\"servingSelect\" id=\"servingSelect\">";
	$servingValue = "";
	if(isset($_POST['servingSelect'])){
		$servingValue = $_POST['servingSelect'];
	}

	for($i = 1; $i <= 10; $i++){
		$chooseDaysString .= "<option ";
		if($i == $servingValue){
			$chooseDaysString .= "selected=\"selected\" ";
		}
		$chooseDaysString .= "value=". $i .">" . $i . "</option>";
	}

	$chooseDaysString .= "</select>";
	$chooseDaysString .= "<input type=\"submit\" id=\"daysButton\" name=\"createCalander\" value=\"Create\" />";

	$chooseDaysString .= "</div>";
	return $chooseDaysString;
}

//Calls the function and assigns the result to a variable
$chooseDayString = createDayCheckboxes($fullList);

//Creates the html for each calander day
function createCalanderDay($day){

	$today = $day;
	$dayLower = strtolower($today);
	$breakfastLabel = $dayLower . "Breakfast";
	$breakfastDiv = $breakfastLabel . "Div";
	$lunchLabel = $dayLower . "Lunch";
	$lunchDiv = $lunchLabel . "Div";
	$dinnerLabel = $dayLower . "Dinner";
	$dinnerDiv = $dinnerLabel . "Div";

	$dayString = "";
	$dayString .= "<div>";
	$dayString .= "<fieldset class="."dayField".">";
	$dayString .= "<legend>" . $day . "</legend>";

	//Breakfast
	$dayString .= "<label for=" . $breakfastLabel . ">Breakfast</label>";
	$labelValue1 = checkisset($breakfastLabel);
	$dayString .= "<input type=\"text\" name=" . $breakfastLabel . " value=\"$labelValue1\" class=\"recipeInput\" maxlength=\"50\" />";
	$dayString .= "<div "."id=".$breakfastDiv." ></div>";

	//Lunch
	$dayString .= "<label for=" . $lunchLabel . ">Lunch</label>";
	$labelValue2 = checkisset($lunchLabel);
	$dayString .= "<input type=\"text\" name=" . $lunchLabel . " value=\"$labelValue2\" class=\"recipeInput\" maxlength=\"50\" />";
	$dayString .= "<div "."id=".$lunchDiv." ></div>";


	//Dinner
	$dayString .= "<label for=" . $dinnerLabel . ">Dinner</label>";
	$labelValue3 = checkisset($dinnerLabel);
	$dayString .= "<input type=\"text\" name=" . $dinnerLabel . " value=\"$labelValue3\" class=\"recipeInput\" maxlength=\"50\" />";
	$dayString .= "<div "."id=".$dinnerDiv." ></div>";

	$dayString .= "</fieldset>";
	$dayString .= "</div>";

	return $dayString;
};

//Makes the calander days sticky
function checkisset($label) {
	$label = $label;
	$value = "";
	if(isset($_POST[$label])) {
		$value = $_POST[$label];
	}
	return $value;
}

//FORM PROCESS
if($_SERVER['REQUEST_METHOD'] == "POST"){


	//Form process takes the info from the checkboxes and creates the calander days
	if(isset($_POST['Create'])){

	};
	$calanderString = "";
	if(isset($_POST['sundayBox'])){
		$currentDay = "Sunday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['mondayBox'])){
		$currentDay = "Monday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['tuesdayBox'])){
		$currentDay = "Tuesday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['wednesdayBox'])){
		$currentDay = "Wednesday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['thursdayBox'])){
		$currentDay = "Thursday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['fridayBox'])){
		$currentDay = "Friday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}
	if(isset($_POST['saturdayBox'])){
		$currentDay = "Saturday";
		$newDay = createCalanderDay($currentDay);
		$calanderString .= $newDay;
	}

	//FORM PROCESS if the form is posted through the search button, keep the calander and it's information
	if(isset($_POST['search'])){
		$type = $_POST['typeSelect'];
		//$catagory = $_POST['catagorySelect'];
		$search = $_POST['searchBox'];

		//DATABASE QUERY
		function searchQuery($type, /*$catagory,*/ $searchBox, $db) {
			$type = $type;
			//$catagory = $catagory;
			$search = $searchBox;
			$returnString = '';

			if($type != 'tag') {
				$sql = "SELECT DISTINCT recipe_info.recipe_name, recipe.servings FROM recipe, recipe_info WHERE (recipe.recipe_name = recipe_info.recipe_name) AND (recipe_info.$type = '$search')";
				$result = $db->query($sql);
				$returnString .= "<dl>";
				while($rows = $result->fetch_row()){
					/*$returnString .= "<div class="."draggable"." class="."ui-widget-content"." class="."recipeDiv"." >";*/
						$returnString .= "<dt class="."draggable"." class="."ui-widget-content"." name=".$rows[1].">";
							$returnString .= "$rows[0]";

						$returnString .= "</dt>";
						$returnString .= "<dd>".$rows[1]."</dd>";
					/*$returnString .= "</div>";*/
					//Set serving value
				}
				$returnString .= "</dl>";
			}
			return $returnString;
		}

	$searchResults = searchQuery($type, /*$catagory,*/ $search, $db);
	}
}

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




		<!-- THE MASTER FORM!! -->
		<form id="masterForm" action="" method="POST">

		<!-- form for choosing the days of the week -->
		<div id="chooseDaysDiv">
			<?php
				echo $chooseDayString;
			?>
		</div>

		<!-- form for meal prep calander -->
		<div id="calanderDiv">
			<?php
				echo $calanderString;
			?>
		</div>
			<fieldset>

			<!-- Search Box -->
			<legend>Search Recipes</legend>
				<label for="typeSelect">Select Search Type: </label>
				<select name="typeSelect">
					<option value="recipe_name">Recipe Name</option>
					<option value="ingredient_name">Ingredient</option>
					<option value="tag">Tag</option>
				</select>
				<label for="catagorySelect">Select Meal Type: </label>
				<!--<select name="catagorySelect">
					<option value=""></option>
					<option value="breakfast">Breakfast</option>
					<option value="lunch">Lunch</option>
					<option value="dinner">Dinner</option>
				</select>-->
				<label for="searchBox"></label>
				<input type="text" name="searchBox" maxlength="50">
				<input type="submit" value="search" name="search">
			</fieldset>


		</form>

		<!-- Display Recipes -->
		<div id="displayRecipesDiv">
			<?php
				echo $searchResults;
			?>
		</div>

	</content>

</div><!-- end wrapper -->

<script>

	//Make the text boxes in the form droppable
	$(".recipeInput").addClass("droppable");


	$( function() {
		$( ".draggable" ).draggable({
			cursor : 'pointer',
			revert : true,
			revertDuration : 250,
			start: function( event, ui ) {
				//Select the recipe name
				$dropText = $(this).text();
				$servingValue = $(this).context.attributes[1].value;
				console.log($dropText);
				console.log($servingValue);
			}
		});

		//get the number of people
		var people = $("#servingSelect").val();
		console.log(people);
		$(".droppable").droppable({
			activeClass : 'highlight',
			tolerance : 'pointer',
			drop : function(event, ui, droptext) {
				$(this).val($dropText);
				console.log($dropText);
				//Create a function that inputs the serving value of the recipe, subtracts the selected servings, and outputs the new number to a div next to the textbox
				var leftoverServings = servingMath(people, $servingValue);
				console.log(leftoverServings);
				$(this).append("<p>" + leftoverServings + "</p>");
			}
		});

		//Function to calculate servings
		function servingMath(people, recipeServings) {
			var people = people;
			var recipeServings = recipeServings;
			var leftover = recipeServings - people;
			return leftover;
		}
	} );
</script>
</body>
</html>
