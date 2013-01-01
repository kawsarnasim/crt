<?PHP

require_once("./include/membersite_config.php");
$loggedin = FALSE;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = TRUE;
} else {
    $usertype = 3;
}
?>

<?php

include 'header_start.php';
?>

<?php

include 'header_end.php';
?>