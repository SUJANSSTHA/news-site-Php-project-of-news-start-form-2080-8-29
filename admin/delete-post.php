<?php 
include("config.php");
$post_id = $_GET["id"];
$cat_id = $_GET["catid"];

$sql = "DELETE FROM post WHERE post_id = {$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$cat_id}";

if(mysqli_multi_query($conn, $sql)) {
    header("Location: {$hostname}/admin/post.php");
    exit(); // Added exit() to terminate script execution after redirection
} else {
    echo "Query failed: " . mysqli_error($conn);
}
?>
