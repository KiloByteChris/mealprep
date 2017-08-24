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

		$sql = "SELECT * FROM recipe";
		$result = $db->query($sql);
		/* var_dump($result);   */

		$rows = $result->fetch_all(); 
		/* var_dump($rows); */
		
		for($i = 0; $i<count($rows); $i++){
			$linkName = $rows["$i"][1];
			echo "<a href="."view_recipe.php/?recipe=$linkName".">$linkName</a>";
			echo "<br>";
		};

	?>
</body>
</html>