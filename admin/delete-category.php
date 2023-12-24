<?php

include "config.php";

$category_id = $_GET["id"];


$sql = "DELETE FROM category WHERE category_id = {$category_id}";

if(mysqli_query($conn, $sql)) {
    header("Location:{$hostname}/admin/category.php");
}else{
echo"<p stype='color:red; margin: 10px 0;'>Can\'t Delete the user Record</p>";
}
mysqli_close($conn);
?>