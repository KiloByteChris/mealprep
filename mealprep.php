<!DOCTYPE HTML>
<html lang="en">
<head>

	<meta charset="utf-8" >
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="css/mealprep.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="js/calander_generator.js"></script>
	<title>mealprep</title>
	
	
</head>

<body>
<?php
	require "database/mysqli_connect.inc.php";
?>


<div id="pageWrapper">
	<header>
		<h1>Meal Prep</h1>
		
		<nav>
			<a href="newrecipe.html">New Recipe</a>
			<a href="browse_recipes.php">Browse Recipes</a>
			<a href="saved_plans.php">Saved Meal Plans</a>
		</nav>
	</header>
	
	<content>
		<div id="chooseDaysDiv">
		</div>
		
		<div id="calanderDiv>
		</div>
	</content>
	
	<!-- Search Box -->
	
	<form id="searchForm" action="mealprep.php" method="GET">
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
	<p></p>
	
	
	<!-- Display Recipes -->
	<div id="displayRecipesDiv">
	
	</div>
	
	<?php
	$type ='';
	$catagory = '';
	$search = '';
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		if(isset($_GET['typeSelect'])) {
			$type = $_GET['typeSelect'];
		}
		if(isset($_GET['catagorySelect'])) {
			$catagory = $_GET['catagorySelect'];
		}
		if(isset($_GET['searchBox'])) {
			$search = $_GET['searchBox'];
		}
		
		
		if($type != 'tag') {
			$sql = "SELECT DISTINCT recipe_info.recipe_name FROM recipe, recipe_info WHERE (recipe.recipe_name = recipe_info.recipe_name) AND (recipe_info.$type = '$search') AND (recipe.recipe_catagory = '$catagory') ";
			$result = $db->query($sql);
			echo "<ul>";
			while($rows = $result->fetch_row()){
				echo "<div class="."draggable"." class="."ui-widget-content".">";
					echo "<li>";
						echo "$rows[0]";
					echo "</li>";
				echo "</div>";
			}
			echo "</ul>";
		}
	}
	
	?>
	<script>
	
	//Javascript for choosing the days and generatrting the calanderDiv
	var chooseDaysDiv = document.getElementById("chooseDaysDiv");
	console.log(chooseDaysDiv);
	var weekForm =  new Calander();
	console.log(weekForm);
	var chooseDaysFormString = chooseDays(fullList);
	console.log(chooseDaysFormString);
	chooseDaysDiv.innerHTML += chooseDaysFormString;




	$(":text").addClass("droppable");
	
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
</div> <!-- end page wrapper -->
</body>
</html>