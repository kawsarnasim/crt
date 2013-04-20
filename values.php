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
            Values
        </div>
        <p>These serve as guidelines for our conduct and behavior as we work towards our vision.</p>
        <div class="topic_body">
            <ul>
                <li><b>Quality</b> - our focus is on the people we serve and we will strive for excellence through evaluation and continuous improvement.</li>
                <li><b>Caring</b> - we are committed to serving with empathy and compassion.</li>
                <li><b>Integrity</b> - we are committed to act in an ethical, honest manner.</li>
                <li><b>Respect</b> - we believe that all people should be treated with consideration and dignity. We cherish diversity.</li>
                <li><b>Responsiveness</b> - we strive to be accessible, flexible, transparent, and to demonstrate a sense of urgency in our resolve and decision-making.</li>
                <li><b>Accountability</b> - we are committed to measuring, achieving and reporting results, and to using donor dollars wisely.</li>
                <li><b>Teamwork</b> - we are committed to effective partnerships between volunteers and staff, and we seek opportunities to form alliances with others.</li>
            </ul>
        </div>
    </div>

<?php
    include 'footer.php';
?>