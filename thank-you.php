<?php
include 'authenticate.php';
include 'header2.php';
?>
<?PHP
if ($loggedin) {
    $fgmembersite->LogOut();
}
?>
<div id="main_content" align="center">
    <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css">
    <div id='fg_membersite_content'>
        <h2>Thanks for registering!</h2>
        Your confirmation email is on its way. Please click the link in the 
        email to complete the registration.
    </div>
    <?php
    include 'footer.php';
    ?>