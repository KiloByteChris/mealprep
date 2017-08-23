<?php

	/* form process for the new recipe form */
	
	require "../database/mysqli_connect.inc.php";
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$recipeTitle = $_POST['recipeTitle'];
		$recipeDescription = $_POST['recipeDescription'];
		$recipeDirections = $_POST['recipeDirections'];
		$recipeCategory = $_POST['recipeCategory'];
		
		$ingName = $_POST['ingName'];
		$ingAmount = $_POST['ingAmount'];
		$ingUnit = $_POST['ingUnit'];
		
		$tags = $_POST['tags'];
		/* var_dump($_POST); */
		
		$sql = "INSERT INTO recipe (recipe_name, recipe_description, recipe_Directions, recipe_category) Values ('$recipeTitle', '$recipeDescription', '$recipeDirections', '$recipeCategory')" ;
		$result = $db->query($sql);
		/* var_dump($result); */
		
		$sql = "INSERT INTO ingredients (ingredient_name) VALUES ('$ingName')";
		$result = $db->query($sql);
		/* var_dump($result); */
		
		$sql = "INSERT INTO recipe_info (amount, unit) Values ('$ingAmount', '$ingUnit')";
		$result = $db->query($sql);
		/* var_dump($result); */
		
		$tagList= explode(', ', $tags);
		var_dump($tagList);
		for($i = 0; $i < count($tagList); $i++) {
			$tagInsert = $tagList[$i];
			$sql = "INSERT INTO tags (tag) VALUES ('$tagInsert')";
			$result = $db->query($sql);
			var_dump($result);
		}
	}

?>