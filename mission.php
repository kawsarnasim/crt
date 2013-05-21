<?php
include 'header2.php';

$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = true;
} else {
    $usertype = 3;
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

        <br/>

        <div class="topic_head">
            Mission
        </div>

        <div class="topic_body">
            The Centre for Research and training (CRT) is a platform strategic policy making research centre, 
            a development-based organization of volunteers whose 			 
            mission is the eradication of discrimination and set the frontline strategic issues 
            for the state, society, economy and  the enhancement of the quality of 
            life of people by working for a fair market and world.
        </div>
    </div>

<?php
include 'footer.php';
?>