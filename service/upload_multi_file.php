<?php
include("../properties.php");
//require_once("../include/data/fileinfo.php");
require_once("../include/util/filemanager.php");
require_once("../include/util/utils.php");

$num_of_files = count($_FILES["file"]["name"]);
$filestr = "";
for ($i = 0; $i < $num_of_files; $i = $i + 1) {
    if ($_FILES["file"]["error"][$i] > 0) {
        $filestr .= "Error: " . $_FILES["file"]["error"][$i];
    } else {
        //echo "Stored in: " . $_FILES["file"]["tmp_name"][$i]."<br>";
        
        $utils = new Utils();
        $fileManager = new FileManager();
        $fileManager->InitDB($dbhost, $dbusername, $dbpwd, $dbname);
        
        $fileName = $utils->generateRandomString();
        while(file_exists("uploads/" . $fileName)) {
            $fileName = $utils->generateRandomString();
        }
        
        $fileDisplayName = $_FILES["file"]["name"][$i];
        
        $ext = pathinfo($fileDisplayName, PATHINFO_EXTENSION);
        $fileName .= ".".$ext;
        
        $fileType = $_FILES["file"]["type"][$i];
        $fileSize = $_FILES["file"]["size"][$i];
        $fileLocation = $_SERVER['SERVER_NAME'] ."/uploads/" . $fileName;
                
        move_uploaded_file( $_FILES["file"]["tmp_name"][$i], "../uploads/" . $fileName );
        
        $fileId = $fileManager->saveFile($fileDisplayName, $fileType, $fileSize, $fileLocation);
        
        $filestr .=  $fileId . "|"
            . $fileDisplayName . "|"
            . $fileType . "|"
            . $fileSize . "|"
            . $fileLocation . ",";
        
    }
}

echo $filestr;
?> 