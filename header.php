<?PHP
require_once("./include/membersite_config.php");
$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = true;
} else {
    $usertype = 3;
}
?>

<?php
include 'header_start.php';
?>

<div id="news_flash">
    News Flash
</div>


<div id="photo_flash">
    <!-- jQuery handles to place the header background images -->
    <div id="headerimgs">
        <div id="headerimg1" class="headerimg"></div>
        <div id="headerimg2" class="headerimg"></div>
    </div>
    <!-- Slideshow controls -->
    <div id="headernav-outer">
        <div id="headernav">
            <div id="back" class="btn"></div>
            <div id="control" class="btn"></div>
            <div id="next" class="btn"></div>
        </div>
    </div>
</div>

<?php
include 'header_end.php';
?>