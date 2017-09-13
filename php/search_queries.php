<?php
	
	require "../database/mysqli_connect.inc.php";
	function searchQuery($type, $catagory, $searchBox) {
		$type = $type;
		$catagory = $catagory;
		$search = $search;
		$returnString = '';
		
		if($type != 'tag') {
			$sql = "SELECT recipe_info.recipe_name FROM recipe, recipe_info WHERE (recipe.recipe_name = recipe_info.recipe_name) AND (recipe_info.$type = '$search') AND (recipe.recipe_catagory = '$catagory') ";
			$result = $db->query($sql);
			$returnString += "<ul>";
			while($rows = $result->fetch_row()){
				$returnString += "<div class="."draggable"." class="."ui-widget-content".">";
					$returnString += "<li>";
						$returnString += "$rows[0]";
					$returnString += "</li>";
				$returnString += "</div>";
			}
			$returnString += "</ul>";
		}
		return $returnString;
	}
?>