<?php

include ("config.php");
if(empty($_FILES["new-image"]["name"])){
    $file_name = $_POST['old_image'];
}else{

    $errors = array();

    $file_name = $_FILES["new-image"]["name"];
    $file_size = $_FILES["new-image"]["size"];
    $file_tmp = $_FILES["new-image"]["tmp_name"];
    $file_type = $_FILES["new-image"]["type"];

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
}


 $sql = "UPDATE post set title = '{$_POST["post_title"]}', description = '{$_POST["postdesc"]}', category = {$_POST["category"]}, post_img = '{$file_name}' WHERE post_id = {$_POST["post_id"]}";
// die();
$result = mysqli_query($conn, $sql);

if($result){
    header("Location:{$hostname}/admin/post.php");
}else{
    echo ("query failed");
}

?>