<?php
require_once("properties.php");
require_once("./include/util/notice.php");

include 'header2.php';
?>

<?php
if($loggedin && $usertype==1) { // Page content can be accessed only if loggedin as admin
    $notice = new Notice();
    $notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
    $allNotices = $notice->getAllNotices();
?>
<div id="main_content2" align="center">
    <style>
        input, textarea { display:block; }
        label { display:block; text-align: left; }
        input.text, textarea.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { font-size: 1.2em; margin: .6em 0; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; }
        span.ui-icon { cursor: pointer;}
    </style>

    <script>
        function removeTableRow(trId){
            $('#tr' + trId).remove();
        }
        
        function getNoticeRowString(id, ttl, txt) {
            var str =
                '<tr id="tr'+id+'">' +
                     '<td id="tdtitle'+id+'" style="width: 25%;">'+ttl+'</td>' +
                     '<td id="tdtext'+id+'">'+txt+'</td>' +
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
            $( "#iddelete" ).val(id);
            $( "#dialog-confirm-delete" ).dialog( "open" );
        }

        function editNotice(id) {
            $( "#idedit" ).val(id);
            
            $( "#ntitle" ).val(  $( "#tdtitle"+id ).text() );
            $( "#ntext" ).val(  $( "#tdtext"+id ).text() );
            
            $( "#dialog-add-notice" ).dialog( "open" );
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
                <tr id="tr<?php echo $noticeInfo->getId() ?>">
                    <td id="tdtitle<?php echo $noticeInfo->getId() ?>" style="width: 25%;"><?php echo $noticeInfo->getTitle(); ?></td>
                    <td id="tdtext<?php echo $noticeInfo->getId() ?>"><?php echo $noticeInfo->getText(); ?></td>
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
                <label for="ntitle">Title</label>
                <input type="text" name="ntitle" id="ntitle" class="text ui-widget-content ui-corner-all" /><br/>
                <label for="ntext">Text</label>
                <textarea type="text" name="ntext" id="ntext" class="text ui-widget-content ui-corner-all" ></textarea><br/>
<!--                <label for="file">Filename:</label>
                <input type="file" name="file[]" id="file" multiple>-->
            </fieldset>
        </form>
    </div>
    
    <input type="hidden" id="iddelete" name="iddelete" value="0" />
    <div id="dialog-confirm-delete" title="Delete this notice?">
        <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The notice will be permanently deleted and cannot be recovered. Are you sure?</p>
    </div>
    
    <input type="hidden" id="idedit" name="idedit" value="0" />


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
                height: 350,
                width: 350,
                modal: true,
                buttons: {
                    "Save notice": function() {
                        var edit_notice_id = $("#idedit").val();
                        allFields.removeClass( "ui-state-error" );
                        if(notice_title.val().length==0) {
                            updateTips("Title should not be empty");
                        } else if(notice_txt.val().length==0) {
                            updateTips("Description should not be empty");
                        } else {
                            var dataString = "notice_title=" + notice_title.val() + "&notice_text="+notice_txt.val()+"&delete_notice_id=0"+"&edit_notice_id="+edit_notice_id;
                            var thisdialog = this;
                            $.ajax({  
                                type: "POST",  
                                url: "savenotice.php",  
                                data: dataString,
                                success: function(response){  
                                    if(response > 0) {
                                        $( "#notices tbody" ).append( getNoticeRowString(response, notice_title.val(), notice_txt.val() ) );
                                        $( thisdialog ).dialog( "close" );
                                    } else if(response=="success"){
                                        $( "#tdtitle"+edit_notice_id ).text( notice_title.val() );
                                        $( "#tdtext"+edit_notice_id ).text( notice_txt.val() );
                                        $( thisdialog ).dialog( "close" );
                                    } else {
                                        updateTips("Database error, could not save notice.");
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
                $("#idedit").val(0)
                $( "#dialog-add-notice" ).dialog( "open" );
            });
            
            $( "#dialog-confirm-delete" ).dialog({
                autoOpen: false,
                resizable: false,
                height:140,
                modal: true,
                buttons: {
                    "Delete notice": function() {
                        var deleteid = $("#iddelete").val();
                        var dataString = "notice_title=" + "&notice_text="+"&delete_notice_id=" + deleteid + "&edit_notice_id=0";
                        var thisdialog = this;
                        $.ajax({  
                            type: "POST",  
                            url: "savenotice.php",  
                            data: dataString,
                            success: function(response){  
                                if(response == "success") {
                                    removeTableRow( deleteid );
                                } else {
                                    alert("Database error, could not delete notice.");
                                }
                                $( thisdialog ).dialog( "close" );
                            }  
                        });
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
                                    
        });
    </script>


<?php
include 'footer2.php';
} else {
?>
<div id="main_content" align="center">
    <div class="topic">
        <div class="topic_head">
            Please log in as administrator to view the content of this page.
        </div>
    </div>

<?php
include 'footer.php';
}
?>