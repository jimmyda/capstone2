<?php
function uploadFile($target_dir, $target_name, $fileType, $target_tmp_name, $post_info) {
    $target_file = $target_dir . $target_name;
    $uploadOk = 0;
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br/>";
        //$uploadOk = 0;
    }
    // Check if file is a actual or fake file
    else if(isset($post_info)) {
        
        echo "file is uploaded.<br/>";
        $uploadOk = 1;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br/>";
    // if everything is ok, try to upload file
    }
    else {
        if (move_uploaded_file($target_tmp_name, $target_file)) {
            echo "The file ". $target_name. " has been uploaded.<br/>";
            echo "File's extension is \"". $fileType. "\".<br/>";
        }
        else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>