<!DOCTYPE HTML>
<html lang="en">
<head>

	<meta charset="utf-8" >
	<title>Browse Recipes</title>
</head>
<body>
	
	<h1>Browse Recipes</h1>
	
	<div id="recipeDisplay">
	</div>
	<?php 	
		/* require "php/queries.php";  */
		require "database/mysqli_connect.inc.php";

		$sql = "SELECT recipe_name FROM recipe";
		$result = $db->query($sql);
		/* var_dump($result);  */

		$rows = $result->fetch_assoc(); 
		var_dump($rows);
		
		for($i = 0; $<=$rows.count; $i++){
			
		};

	?>
</body>
</html>