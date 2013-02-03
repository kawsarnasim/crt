<?php
define('__ROOT__', dirname(__FILE__));
include("properties.php");
//require_once(__ROOT__."/include/data/fileinfo.php");
require_once(__ROOT__."/include/util/filemanager.php");

$success_msg = "success";
if(isset ($_POST['fileid']) ) {
    
    $fileManager = new FileManager();
    
    $fileid = $_POST['fileid'];
    $location = "";
    
    if(!isset ($_POST['location'])) {
        $location = $fileManager->getLocation($fileid);
    } else {
        $location = $_POST['location'];
    }
    
    if(strcmp($location,"") == 0) {
        $success_msg = "file not found";
    } else {
        
        if(!$fileManager->deleteFile($fileid)) {
            $success_msg ="could not delete the file from database";
        } else if(!unlink($location)) { // delete from file system only after successful deletion from database
            $success_msg = "could not delete the file from file system";
        }
    }
    
} else {
    $success_msg = "fail";
}

echo $success_msg;
?> 