<?php
require_once("./include/membersite_config.php");
$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = true;
} else {
    $usertype = 3;
}

include 'header2.php';

?>

<div id="main_content" align="center">
    <div class="topic">
        <div class="topic_head">
            Photo Gallery
        </div>
        <div class="topic_body">
            Photos will be available soon.
        </div>
    </div>

<?php
include 'footer.php';
?>