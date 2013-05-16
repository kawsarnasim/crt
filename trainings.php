<?php
require_once("properties.php");
require_once("./include/util/training.php");
include 'header2.php';

$query_str = $_SERVER['QUERY_STRING'];
$ttype= '';

if( strcmp($query_str, '') != 0 ) {
    $ttypearray = preg_split('/[=]/', $query_str);
    $ttype = $ttypearray[1];
}

$trainings = array();
$training = new Training();
$training->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
$trainingType = 0;
if(strcmp($ttype, "ongoing")==0) {
    $trainingType = 1;
    $trainings = $training->getOngoingTrainings();
} else if(strcmp($ttype, "upcoming")==0) {
    $trainingType = 3;
    $trainings = $training->getFutureTrainings();
} else if(strcmp($ttype, "completed")==0) {
    $trainingType = 2;
    $trainings = $training->getPastTrainings();
}
?>

<div id="main_content" align="center">
    
    <div class="topic">
        <div class="topic_head">
            Training
        </div>

        <?php
        if(count($trainings) > 0) {
            foreach($trainings as $trainingInfo) {
            ?>
                <div class="topic_body">
                    <div>
                        <table cellpadding="0" cellspacing="1">
                            <tr>
                                <th>
                                    <?php echo $trainingInfo->getTitle(); ?>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo $trainingInfo->getDescription(); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
                <div class="topic_body">
                    <div>
                        There is no <?php echo $ttype; ?> training available to show at the moment.
                    </div>
                </div>
            <?php
        }
        ?>
    </div>

<?php
include 'footer.php';
?>