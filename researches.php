<?php
require_once("properties.php");
require_once("./include/util/research.php");
include 'header.php';

$query_str = $_SERVER['QUERY_STRING'];
$rtype= 'nothing';

if( strcmp($query_str, '') != 0 ) {
    $rtypearray = preg_split('/[=]/', $query_str);
    $rtype = $rtypearray[1];
}

$researches = array();
$research = new Research();
$research->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
$researchType = 0;
if(strcmp($rtype, "ongoing")==0){
    $researchType = 1;
    $researches = $research->getOngoingResearches();
} else if(strcmp($rtype, "upcoming")==0){
    $researchType = 3;
    $researches = $research->getFutureResearches();
} else if(strcmp($rtype, "completed")==0){
    $researchType = 2;
    $researches = $research->getPastResearches();
}
?>

<div id="main_content" align="center">
    
    <div class="topic">
        <div class="topic_head">
            Research
        </div>

        <?php
        foreach($researches as $researchInfo) {
        ?>
            <div class="topic_body">
                <div>
                    <table cellpadding="0" cellspacing="1">
                        <tr>
                            <th>
                                <?php echo $researchInfo->getTitle(); ?>
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $researchInfo->getDescription(); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

<?php
include 'footer.php';
?>