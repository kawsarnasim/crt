<?php

require_once("properties.php");
require_once("./include/util/training.php");

require_once("./include/membersite_config.php");

$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = TRUE;
}

if ($loggedin && $usertype == 1) { // This page can accessed only if logged in as administrator
    $training = new Training();
    $training->InitDB($dbhost, $dbusername, $dbpwd, $dbname);

    if (isset($_POST['training_title']))
        $title = $_POST['training_title'];
    else
        $title = "";

    if (isset($_POST['training_text']))
        $description = $_POST['training_text'];
    else
        $description = "";

    if (isset($_POST['start_date']))
        $startDate = $_POST['start_date'];
    else
        $startDate = "";

    if (isset($_POST['end_date']))
        $endDate = $_POST['end_date'];
    else
        $endDate = "";

    if (isset($_POST['delete_training_id']))
        $deleteid = $_POST['delete_training_id'];
    else
        $deleteid = 0;

    if (isset($_POST['edit_training_id']))
        $editid = $_POST['edit_training_id'];
    else
        $editid = 0;

    if ($deleteid > 0) {
        $res = $training->deleteTraining($deleteid);
        echo $res;
    } else if ($editid > 0) {
        echo $training->updateTraining($editid, $title, $startDate, $endDate, $description);
    } else if (strcmp($title, "") != 0 && strcmp($description, "") != 0) {
        echo $training->createTraining($title, $description, $startDate, $endDate);
    }
} else {
    $fgmembersite->RedirectToURL("index.php");
}
?>
