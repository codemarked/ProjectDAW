<?php
session_start();
include('mysql/config.php');

if (isset($_POST['submit'])) {
    $files = array_filter($_FILES['upload']['name']);
    $totalCount = count($_FILES['upload']['name']);
    
    
    if (isset($_POST['description'])) {
        mysql_query($connection, "INSERT INTO `posts` (sender, description) VALUES ('$sender', '$descrpition');");
    } else {
        mysql_query($connection, "INSERT INTO `posts` (sender) VALUES ('$sender');");
        
    }
    
    for( $i=0 ; $i < $totalCount ; $i++ ) {
        $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
        $extension = pathinfo($tmpFilePath, PATHINFO_EXTENSION);
        if ($tmpFilePath != ""){
            $newFilePath = "./uploaded/".time()."_".$_FILES['upload']['name'][$i];
            if (!in_array($extension, ['zip', 'pdf', 'docx'])) {
                echo "You file extension must be .zip, .pdf or .docx";
            } else if ($_FILES['myfile']['size'] > 10000000) { // file shouldn't be larger than 10Mb
                echo "File too large!";
            } else {
                if (move_uploaded_file($file, $newFilePath)) {
                    mysql_query($connection, "INSERT INTO `files` (post_id, file_name, file_path, file_size) VALUES ('$post_id', '$file_name', $file_size);");
                } else {
                    echo "Failed to upload file.";
                }
            }
        }
    }
}
?>