<?php
include 'header.php';

$query_str = $_SERVER['QUERY_STRING'];
$ttype= 'nothing';

if( strcmp($query_str, '') != 0 ) {
    $ttypearray = preg_split('/[=]/', $query_str);
    $ttype = $ttypearray[1];
}

$trainingType = 0;
if(strcmp($rtype, "ongoing")==0){
    $trainingType = 1;
} else if(strcmp($rtype, "upcoming")==0){
    $trainingType = 3;
} else if(strcmp($rtype, "completed")==0){
    $trainingType = 2;
}
?>

<div id="main_content" align="center">
    
    <div class="topic">
        <div class="topic_head">
            Research
        </div>

        <?php
        if($trainingType == 1) {
        ?>
        <div class="topic_body">
            <div>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Ongoing Research Topic 1</th>
                    </tr>
                    <tr>
                        <td>
                            Ongoing Research Body 1<br/>
                            Description of the research
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Ongoing Research Topic 2</th>
                    </tr>
                    <tr>
                        <td>
                            Ongoing Research Body 2<br/>
                            Some Other text
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        } else if($trainingType == 2) {
        ?>
        <div class="topic_body">
            <div>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Completed Research Topic 1</th>
                    </tr>
                    <tr>
                        <td>
                            Completed Research Body 1 <br/>
                            some more text
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Completed Research Topic 2</th>
                    </tr>
                    <tr>
                        <td>
                            Completed Research Body 2<br/>
                            More Text here
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        } else if($trainingType == 3) {
        ?>
        <div class="topic_body">
            <div>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Upcoming Research Topic 1</th>
                    </tr>
                    <tr>
                        <td>
                            Upcoming Research Body 1 <br/>
                            Detailed description
                        </td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="1">
                    <tr>
                        <th>Upcoming Research Topic 2</th>
                    </tr>
                    <tr>
                        <td>
                            Upcoming Research Body 2 <br/>
                            Detailed Description
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