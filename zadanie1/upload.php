<?php
if( isset($_POST['title']) && isset($_FILES["fileToUpload"])){
    $extension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);
    $filename = "uploads/".$_POST['title'].".$extension";

// Check if file already exists
    if (file_exists($filename)) {
        $filename = "uploads/".$_POST['title'].date("d.m.Y h:i:s", time()).".$extension";
    }

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filename);
    header("Location: https://site101.webte.fei.stuba.sk/zadaniadsf/zadanie1/index.php?path=/var/www/site101.webte.fei.stuba.sk/zadaniadsf/zadanie1/uploads/");
    exit;

}
