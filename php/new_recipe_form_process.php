<?php

	/* form process for the new recipe form */
	
	require "../database/mysqli_connect.inc.php";
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$recipeTitle = $_POST['recipeTitle'];
		$recipeDescription = $_POST['recipeDescription'];
		$recipeDirections = $_POST['recipeDirections'];
		$recipeCategory = $_POST['recipeCategory'];
		
		
		$tags = $_POST['tags'];
		
		$sql = "INSERT INTO recipe (recipe_name, recipe_description, recipe_directions, recipe_category) Values ('$recipeTitle', '$recipeDescription', '$recipeDirections', '$recipeCategory')" ;
		$result = $db->query($sql);
		/* var_dump($result); */
		
		$postLength = count($_POST);
		$postLength = $postLength - 6;
		$postLength = $postLength / 3;
		for($i=1; $i<=$postLength; $i++) {
			
			$ingName = $_POST["ingName$i"];
			$sql = "INSERT INTO ingredients (ingredient_name) VALUES ('$ingName')";
			$result = $db->query($sql);
			
			$ingAmount = $_POST["ingAmount$i"];
			$ingUnit = $_POST["ingUnit$i"];
			$sql = "INSERT INTO recipe_info (recipe_name, ingredient_name, amount, unit) Values ('$recipeTitle', '$ingName', '$ingAmount', '$ingUnit')";
			$result = $db->query($sql);

			var_dump($result);
		}
		
		$tagList= explode(', ', $tags);
		/* var_dump($tagList); */
		for($i = 0; $i < count($tagList); $i++) {
			$tagInsert = $tagList[$i];
			$sql = "INSERT INTO tags (tag) VALUES ('$tagInsert')";
			$result = $db->query($sql);
			/* var_dump($result); */
			
			$sql = "INSERT INTO recipe_tags (recipe_name, tag) VALUES ('$recipeTitle', '$tagInsert')";
			$result = $db->query($sql);
		}
	}

?>