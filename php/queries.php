<?php
	echo "hello";

	require "database/mysqli_connect.inc.php";

$sql = "SELECT * FROM recipe";
$result = $db->query($sql);
var_dump($result);
echo"hello"; 

$rows = $result->fetch(); 
/* $rows = msqli_fetch_all($result); */

?>