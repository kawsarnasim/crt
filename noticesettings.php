<?php
require_once("properties.php");
require_once("./include/util/notice.php");

include 'header2.php';
if($loggedin && $usertype==1) { // Page content can be accessed only if loggedin as admin
    $notice = new Notice();
    $notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
    $allNotices = $notice->getAllNotices();
?>

<style>
    input { display:block; }
    label { display:block; text-align: left; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>

       
<div class="topic">
    <div class="topic_head">
        Notice Settings
    </div>
    <div>
        Here are the notice settings
        <table id="notices">
            <thead>
            <tr>
                <th style="width: 25%;">Title</th>
                <th>Text</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($allNotices as $noticeInfo) {
            ?>
            <tr>
                <td style="width: 25%;"><?php echo $noticeInfo->getTitle(); ?></td>
                <td><?php echo $noticeInfo->getText(); ?></td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <div>
        <button id="add-notice">Add notice</button>
    </div>
</div>

<div id="dialog-add-notice" title="Add new notice">
    <p class="validateTips">All form fields are required.</p>
    <form>
        <fieldset>
            <label for="name">Title</label>
            <input type="text" name="ntitle" id="ntitle" class="text ui-widget-content ui-corner-all" />
            <label for="email">Text</label>
            <input type="text" name="ntext" id="ntext" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>


<script>
    $(function() {
        var notice_title = $( "#ntitle" ),
        notice_txt = $( "#ntext" ),
        allFields = $( [] ).add( notice_title ).add( notice_txt ),
        tips = $( ".validateTips" );
        function updateTips( t ) {
            tips
            .text( t )
            .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }
        
        $( "#dialog-add-notice" ).dialog({
            autoOpen: false,
            height: 250,
            width: 350,
            modal: true,
            buttons: {
                "Add a notice": function() {
                    allFields.removeClass( "ui-state-error" );
                    if(notice_title.val().length==0) {
                        updateTips("Title should not be empty");
                    } else if(notice_txt.val().length==0) {
                        updateTips("Description should not be empty");
                    } else {
                        $( "#notices tbody" ).append( "<tr>" +
                            "<td style=\"width: 25%;\">" + notice_title.val() + "</td>" +
                            "<td>" + notice_txt.val() + "</td>" +
                            "</tr>" );
                        $( this ).dialog( "close" );
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        
        $( "#add-notice" ).button().click(function() {
            $( "#dialog-add-notice" ).dialog( "open" );
        });
    });
</script>


<?php
} else {
    ?>

    <div class="topic">
        <div class="topic_head">
            You are not supposed to view this page.
        </div>
    </div>

    <?php
}
include 'footer.php';
?>