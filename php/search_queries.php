<?php
	
	require "../database/mysqli_connect.inc.php";
	function searchQuery() {
		$type ='';
		$catagory = '';
		$search = '';
		
		//Defining variables from the search form for use in queries
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
	}
?>