<?php
include 'header2.php';
?>

<div id="main_content" align="center">

    <?PHP
    //require_once("./include/membersite_config.php");

    $fgmembersite->LogOut();
    ?>
    <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
    <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
    <h2>You have logged out</h2>
    <p>
        <a href='login.php'>Login Again</a>
    </p>

    <?php
    include 'footer.php';
    ?>