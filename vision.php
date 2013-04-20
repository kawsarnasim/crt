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

if($usertype == 1) {
    include 'header2.php';
} else {
    include 'header.php';
}
?>

<div id="main_content" align="center">
    
    <div class="topic">
        <div class="topic_head">
            Vision
        </div>
        <div class="topic_body">
            Creating a better world by working for a richer economy.
        </div>
    </div>

<?php
    include 'footer.php';
?>