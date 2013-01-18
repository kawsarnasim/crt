<?php
require_once("properties.php");
require_once("./include/util/notice.php");

include 'header2.php';
if($loggedin && $usertype==1) { // Page content can be accessed only if loggedin as admin
    $notice = new Notice();
    $notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
    $allNotices = $notice->getAllNotices();
?>

<div id="main_content2" align="center">

    <style>
        input { display:block; }
        label { display:block; text-align: left; }
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
        span.ui-icon { cursor: pointer;}
    </style>

    <script>
        function getNoticeRowString(id, ttl, txt) {
            var str =
                '<tr>' +
                     '<td style="width: 25%;">'+ttl+'</td>' +
                     '<td>'+txt+'</td>' +
                     '<td style="width: 10px;">' +
                         '<span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editNotice(' + id + ')"></span>' +
                     '</td>' +
                     '<td style="width: 10px;">' +
                         '<span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteNotice(' + id + ')"></span>' +
                     '</td>' +
                 '</tr>';
             return str;
        }
        function deleteNotice(id) {
            alert('Deleting ' + id);
        }

        function editNotice(id) {
            alert('Editing ' + id);
        }
    </script>

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
                    <th colspan="3">Text</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($allNotices as $noticeInfo) {
                ?>
                <tr>
                    <td style="width: 25%;"><?php echo $noticeInfo->getTitle(); ?></td>
                    <td><?php echo $noticeInfo->getText(); ?></td>
                    <td style="width: 10px;">
                        <span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editNotice('<?php echo $noticeInfo->getId(); ?>')"></span>
                    </td>
                    <td style="width: 10px;">
                        <span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteNotice('<?php echo $noticeInfo->getId(); ?>')"></span>
                    </td>
                </tr>
                
<!--                <script>
                    document.write( ''+getNoticeRowString(<?php echo $noticeInfo->getId() ?>, <?php echo $noticeInfo->getTitle(); ?>, <?php echo $noticeInfo->getText(); ?>)+'');
                </script>-->
<!--                <script>
                    var nid = <?php echo $noticeInfo->getId() ?>;
                    var nttl =  '<?php echo $noticeInfo->getTitle(); ?>';
                    var ntxt =  '<?php echo $noticeInfo->getText(); ?>';
                    document.write( getNoticeRowString(nid, nttl, ntxt) );
                </script>-->
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
        <form id="frmnoticeinfo">
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
                            var dataString = "notice_title=" + notice_title.val() + "&notice_text="+notice_txt.val();
                            var thisdialog = this;
                            $.ajax({  
                                type: "POST",  
                                url: "savenotice.php",  
                                data: dataString,
                                success: function(response){  
                                    if(response > 0) {
                                        $( "#notices tbody" ).append( getNoticeRowString(response, notice_title.val(), notice_txt.val() ) );
                                        $( thisdialog ).dialog( "close" );
                                    } else {
                                        updateTips("Database error, could not create notice.");
                                    }
                                }  
                            });

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
       
    
include 'footer2.php';
?>