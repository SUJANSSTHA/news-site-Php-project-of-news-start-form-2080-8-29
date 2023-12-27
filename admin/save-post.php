<?php
include "config.php";

session_start();

if (isset($_FILES["fileToUpload"])) {
    $errors = array();

    $file_name = $_FILES["fileToUpload"]["name"];
    $file_size = $_FILES["fileToUpload"]["size"];
    $file_tmp = $_FILES["fileToUpload"]["tmp_name"];
    $file_type = $_FILES["fileToUpload"]["type"];

    // Extracting file extension using pathinfo
    $file_info = pathinfo($file_name);
    $file_ext = strtolower($file_info['extension']);

    $extensions = array("jpeg", "jpg", "png");

    if (!in_array($file_ext, $extensions)) {
        $errors[] = "This file extension is not allowed. Please upload a JPG, JPEG, or PNG file.";
    }

    if ($file_size > 2097152) { // 2 MB in bytes
        $errors[] = "File size must be 2MB or lower.";
    }

    if (empty($errors)) {
        $upload_directory = "upload/"; // Define your upload directory
        $uploaded_file = $upload_directory . $file_name;

        // Move the uploaded file to the upload directory
        if (move_uploaded_file($file_tmp, $uploaded_file)) {
            // File uploaded successfully
        } else {
            $errors[] = "Failed to upload file.";
        }
    } else {
        print_r($errors);
        die(); // Terminate further execution if errors exist
    }
    // upto here 
}

$title = mysqli_real_escape_string($conn, $_POST["post_title"]);
$description = mysqli_real_escape_string($conn, $_POST["postdesc"]);
$category = mysqli_real_escape_string($conn, $_POST["category"]);
$date = date("d M, Y");
$author = $_SESSION["user_id"];

// Insert post data into the 'post' table
$sql_insert = "INSERT INTO post(title, description, category, post_date, author, post_img) VALUES ('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$file_name}')";

if (mysqli_query($conn, $sql_insert)) {
    // Update the 'category' table to increment the 'post' count for the specified category
    $sql_update = "UPDATE category SET post = post + 1 WHERE category_id = '{$category}'";
    
    if (!mysqli_query($conn, $sql_update)) {
        echo "<div class='alert alert-danger'>Failed to update category.</div>";
    }

    header("Location: {$hostname}/admin/post.php");
} else {
    echo "<div class='alert alert-danger'>Query Failed.</div>";
}
?>
