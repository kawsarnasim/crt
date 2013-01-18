<?php
require_once("properties.php");
require_once("./include/util/notice.php");

$notice = new Notice();
$notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);

$ntitle  = $_POST['notice_title'];
$ntext  = $_POST['notice_text'];

echo $notice->createNotice($ntitle, $ntext);
?>
