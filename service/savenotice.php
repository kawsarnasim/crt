<?php
require_once("properties.php");
require_once("./include/util/notice.php");

require_once("./include/membersite_config.php");

$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = TRUE;
}

if ($loggedin && $usertype==1) { // This page can accessed only if logged in as administrator

    $notice = new Notice();
    $notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);

    if(isset ($_POST['notice_title']))
        $ntitle  = $_POST['notice_title'];
    else
        $ntitle  = "";

    if(isset ($_POST['notice_text']))
        $ntext  = $_POST['notice_text'];
    else
        $ntext = "";

    if(isset ($_POST['delete_notice_id']))
        $ndeleteid = $_POST['delete_notice_id'];
    else
        $ndeleteid = 0;

    if(isset ($_POST['edit_notice_id']))
        $neditid = $_POST['edit_notice_id'];
    else
        $neditid = 0;

    if($ndeleteid > 0)
    {
        echo $notice->deleteNotice($ndeleteid);
    }
    else if($neditid > 0)
    {
        echo $notice->updateNotice($neditid, $ntitle, $ntext);
    }
    else if( strcmp($ntitle, "") != 0 && strcmp($ntext, "") != 0)
    {
        echo $notice->createNotice($ntitle, $ntext);
    }

} else {
    $fgmembersite->RedirectToURL("index.php");
}
?>
