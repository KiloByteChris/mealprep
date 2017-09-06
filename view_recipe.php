<?php
$recipeId = $_GET['recipe'];


require "database/mysqli_connect.inc.php";
/* echo "$recipe"; */
$sql = "SELECT * FROM recipe WHERE recipe_id = '$recipeId'";
/* echo "$sql"; */
$result = $db->query($sql);
/* var_dump($result);  */
$recipeRows = $result->fetch_row();
/* var_dump($recipeRows); */
$recipeName = $recipeRows[1];

echo "<h1>".$recipeRows[1]."</h1>";
echo "<h2>Description</h2>";
echo "<p>".$recipeRows[2]."</p>";
echo "<h2>Directions</h2>";
echo "<p>".$recipeRows[3]."</p>";
echo "<p>Meal Catagory: ". $recipeRows[4]."</p>";
echo "<h2>Ingredients</h2>";


$sql= "SELECT ingredient_name FROM recipe_info WHERE recipe_name = '$recipeName'";
$result = $db->query($sql);
echo "<ol>";
while($row = $result->fetch_row()) {
	echo "<li>".$row[0]."</li>";
}
echo "</ol>";

$sql = "SELECT tag FROM recipe_tags WHERE recipe_name = '$recipeName'";
$result = $db->query($sql);
echo "<h2>Tags</h2>";
echo "<ul>";
while($row = $result->fetch_row()) {
	echo "<li>".$row[0]."</li>";
}
echo "</ol>";
?>