<?php
require_once("properties.php");
require_once("./include/util/notice.php");
require_once("./include/util/filemanager.php");

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

    <script src="js/jquery.form.js"></script>
    
    <script>
        // collected from: http://blog.stevenlevithan.com/archives/faster-trim-javascript
        function trim12 (str) {
            var	str = str.replace(/^\s\s*/, ''),
                    ws = /\s/,
                    i = str.length;
            while (ws.test(str.charAt(--i)));
            return str.slice(0, i + 1);
        }

        function removeTableRow(trId){
            $('#tr' + trId).remove();
        }
        
        function getAttachmentCellString(noticeId) {
            var str =  '';
            var attachedFiles = '';
            var linkrows =  '';
            
            var fileStr = trim12($("#newfiles").text());
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            if(fileStr != "") {
                var fileArray = fileStr.split(',');
                var i ;
            
                for(i = 0; i < fileArray.length; i++) {
                    var fileValues = fileArray[i].split('|');
                    var fileId = fileValues[0];
                    var fileName = fileValues[1];
                    var fileType = fileValues[2];
                    var fileSize = fileValues[3];
                    var fileLocation = fileValues[4];
                    if(i != 0) {
                        attachedFiles += ',';
                    }
                        attachedFiles += fileId + '|' + fileName + '|' + fileType + '|' + fileSize + '|' + fileLocation;

                    linkrows += '<tr><td><a href="'+fileLocation+'">'+fileName+'</a></td></tr>';
                }
            }
            
            str += 
                '<table id="noticefiles'+noticeId+'">'+
                '   <thead></thead>' +
                '   <tbody>' +
                    linkrows +
                '   </tbody>' +
                '</table>' +
                '<input type="hidden" id="attachedfiles'+noticeId+'" value="'+attachedFiles+'"></input>';
            
            return str;
        }
                
        function getNoticeRowString(id, ttl, txt) {
            var str =
                '<tr id="tr'+id+'">' +
                     '<td id="tdtitle'+id+'" style="width: 25%;">'+ttl+'</td>' +
                     '<td id="tdtext'+id+'">'+txt+'</td>' +
                     '<td>'+
                        getAttachmentCellString(id) +
                     '</td>' +
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
            
            var attachedFileStr = $( "#attachedfiles"+id ).val();
            
            if(attachedFileStr.charAt(attachedFileStr.length-1)== ',') {
                attachedFileStr = attachedFileStr.substr(0, attachedFileStr.length-1);
            }
            if(attachedFileStr !=  '') {
                var fileArray = attachedFileStr.split(',');
                var i ;
                for(i = 0; i < fileArray.length; i++) {
                    var fileValues = fileArray[i].split('|');
                    var fileId = fileValues[0];
                    var fileName = fileValues[1];
                    var fileSize = fileValues[3];
                    var fileLocation = fileValues[4];
                    addFileToDialog( fileId, fileName, fileSize, fileLocation );
                }
            }
            
            $( "#dialog-add-notice" ).dialog( "open" );
        }
        
        function addNewFilesToNoticeAttachmentCell(noticeId) {
            var attachedFiles = $( "#attachedfiles"+noticeId ).val();
            if(attachedFiles ==  undefined) {
                attachedFiles = '';
            }
            var fileStr = trim12($("#newfiles").text());
            var linkrows = '';
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            if(fileStr !=  '') {
                var fileArray = fileStr.split(',');
                var i ;
                for(i = 0; i < fileArray.length; i++) {
                    var fileValues = fileArray[i].split('|');
                    var fileId = fileValues[0];
                    var fileName = fileValues[1];
                    var fileType = fileValues[2];
                    var fileSize = fileValues[3];
                    var fileLocation = fileValues[4];

                    if(attachedFiles != '') {
                        attachedFiles += ',';
                    }
                    attachedFiles += fileId + '|' + fileName + '|' + fileType + '|' + fileSize + '|' + fileLocation;

                    linkrows += '<tr id="noticefile'+fileId+'"><td><a href="'+fileLocation+'">'+fileName+'</a></td></tr>';
                }
            }
            
            $( "#attachedfiles"+noticeId ).val(attachedFiles);
            $( "#noticefiles"+noticeId+" tbody" ).append(linkrows);
        }
        
        function deleteFileFromNoticeAttachmentCell(noticeId) {
            var deletedFileIDArray = deletedDialogFiles.split(',');
            
            var attachedFiles = $( "#attachedfiles"+noticeId ).val();
            if(attachedFiles ==  undefined) {
                attachedFiles = '';
            }
            var fileStr = trim12(attachedFiles);
            attachedFiles = '';
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            if(fileStr !=  '') {
                var fileArray = fileStr.split(',');
                var i ;
                for(i = 0; i < fileArray.length; i++) {
                    var fileValues = fileArray[i].split('|');
                    var fileId = fileValues[0];
                    var fileName = fileValues[1];
                    var fileType = fileValues[2];
                    var fileSize = fileValues[3];
                    var fileLocation = fileValues[4];
                    
                    var j;
                    var foundInDeletedFiles=0;
                    for(j= 0 ; j < deletedFileIDArray.length ; j++) {
                        if(fileId==deletedFileIDArray[j]) {
                            foundInDeletedFiles = 1;
                        }
                    }
            
                    if(foundInDeletedFiles == 0) {
                        if(attachedFiles != '') {
                            attachedFiles += ',';
                        }
                        attachedFiles += fileId + '|' + fileName + '|' + fileType + '|' + fileSize + '|' + fileLocation;
                    } else {
                        $('#noticefile' + fileId).remove();
                    }
                }
            }
            
            $( "#attachedfiles"+noticeId ).val(attachedFiles);
        }
        
        
        /** + File Upload **/
        
        function afterSuccess() {
            var fileStr = trim12($("#newfiles").text());
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            var fileArray = fileStr.split(',');
            var i ;
            for(i = 0; i < fileArray.length; i++) {
                var fileValues = fileArray[i].split('|');
                var fileId = fileValues[0];
                var fileName = fileValues[1];
                var fileSize = fileValues[3];
                var fileLocation = fileValues[4];
                addFileToDialog(fileId,fileName, fileSize, fileLocation);
            }
        }
        
        function addFileToDialog(fid, fname, fsize, flocation) {
            var rowStr= "<tr id=\"filetr"+fid+"\">";
            rowStr +=   "   <td><a href=\""+flocation+"\" >"+fname+"</a></td>";
            rowStr +=   "   <td>"+Math.floor( (fsize/1024) * 100) / 100+" KB</td>";
            rowStr +=   "   <td style=\"width: 10px;\">"
                   +    "      <span class=\"icon ui-icon ui-icon-close\" title=\"delete\" onclick=\"addToDeletedFiles('"+fid+"')\"></span>"
                   +    "   </td>";
            rowStr +=   "</tr>";
            
            $("#myFiles tbody").append(rowStr);
        }
        
        var deletedDialogFiles = '';
        function addToDeletedFiles(fid) {
            removeFileRowFromDialog( fid );
            if(deletedDialogFiles== '')
                deletedDialogFiles += fid;
            else
                deletedDialogFiles += ',' + fid;
            
            /* Also remove this file info from the #newfiles div */
            var fileStr = trim12($("#newfiles").text());
            var newFileStr = '';
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            if(fileStr !=  '') {
                var fileArray = fileStr.split(',');
                var i ;
                for(i = 0; i < fileArray.length; i++) {
                    var fileValues = fileArray[i].split('|');
                    var fileId = fileValues[0];
                    var fileName = fileValues[1];
                    var fileType = fileValues[2];
                    var fileSize = fileValues[3];
                    var fileLocation = fileValues[4];
                    if(fileId!=fid) {
                        newFileStr += fileId + '|' + fileName + '|' + fileType + '|' + fileSize + '|' + fileLocation +  ',';
                    }
                }
                $("#newfiles").text(newFileStr);
            }
        }
        
        function deleteUnwantedFilesFromDialog() {
            /*if(trim12(deletedDialogFiles)=='' || trim12(deletedDialogFiles)==',') {
                return;
            }*/
            
            var fileIDArray = deletedDialogFiles.split(',');
            var i;
            for(i= 0 ; i < fileIDArray.length ; i++) {
                deleteFileFromDialog(fileIDArray[i]);
            }
        }
        
        function deleteFileFromDialog(fid) {
            var dataString = "fileid="+fid;
            $.ajax({
                type: "POST",  
                url: "deletefile.php",  
                data: dataString,
                success: function(response){  
                    if(response == "success") {
                        removeFileRowFromDialog( fid );
                    } else {
                        updateTips("Database error, could not delete file ("+fid+")");
                    }
                }
            });
        }
        
        function getAttachedNewFileIDs() {
            var fileStr = trim12($("#newfiles").text());
            var newFileStr = '';
            if(fileStr.charAt(fileStr.length-1)== ',') {
                fileStr = fileStr.substr(0, fileStr.length-1);
            }
            var fileArray = fileStr.split(',');
            var i ;
            for(i = 0; i < fileArray.length; i++) {
                var fileValues = fileArray[i].split('|');
                var fileId = fileValues[0];
                if(i != 0) {
                    newFileStr +=  ',';
                }
                newFileStr += fileId;
            }
            return newFileStr;
        }
        
        function removeFileRowFromDialog(fid) {
            $('#filetr' + fid).remove();
        }

        function submitfile() {
            $('#file').click();
        }
        
        
        /** - File Upload **/
    </script>

    <div class="topic">
        <div class="topic_head">
            Notice Settings
        </div>
        <div>
            <table id="notices">
                <thead>
                <tr>
                    <th style="width: 25%;">Title</th>
                    <th>Text</th>
                    <th>Attachments</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($allNotices as $noticeInfo) {
                ?>
                <tr id="tr<?php echo $noticeInfo->getId() ?>">
                    <td id="tdtitle<?php echo $noticeInfo->getId() ?>" style="width: 25%;"><?php echo $noticeInfo->getTitle(); ?></td>
                    <td id="tdtext<?php echo $noticeInfo->getId() ?>"><?php echo $noticeInfo->getText(); ?></td>
                    <td>
                        <table id="noticefiles<?php echo $noticeInfo->getId() ?>">
                            <thead></thead>
                            <tbody>
                        <?php
                        $fileManager = new FileManager();
                        $fileManager->InitDB($dbhost, $dbusername, $dbpwd, $dbname);
                        $allFiles = $fileManager->getAllFiles($noticeInfo->getFileIDs());
                        $attachedFileStr = "";
                        for($fi = 0; $fi < count($allFiles) ; $fi++) {
                            if($fi != 0) {
                                $attachedFileStr .= ",";
                            }
                            ?>
                                <tr id="noticefile<?php echo $allFiles[$fi]->getId() ?>"><td><a href="<?php echo $allFiles[$fi]->getLocation(); ?>"><?php echo $allFiles[$fi]->getName(); ?></a></td></tr>
                            <?php
                            $attachedFileStr .= $allFiles[$fi]->getId()."|".$allFiles[$fi]->getName()."|".$allFiles[$fi]->getType()."|".$allFiles[$fi]->getSize()."|".$allFiles[$fi]->getLocation();
                        }
                        ?>
                            </tbody>
                        </table>
                        <input type="hidden" id="attachedfiles<?php echo $noticeInfo->getId() ?>" value="<?php echo $attachedFileStr; ?>"></input>
                    </td>
                    <td style="width: 10px;">
                        <span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editNotice('<?php echo $noticeInfo->getId(); ?>')"></span>
                    </td>
                    <td style="width: 10px;">
                        <span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteNotice('<?php echo $noticeInfo->getId(); ?>')"></span>
                    </td>
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
        <p class="validateTips"></p>
        <form id="frmnoticeinfo" action="upload_multi_file.php" enctype="multipart/form-data" method="post">
            <fieldset>
                <label for="ntitle">Title</label>
                <input type="text" name="ntitle" id="ntitle" class="text ui-widget-content ui-corner-all" /><br/>
                <label for="ntext">Text</label>
                <textarea rows="8" type="text" name="ntext" id="ntext" class="text ui-widget-content ui-corner-all" ></textarea><br/>
<!--                <label for="file">Filename:</label>
                <input type="file" name="file[]" id="file" multiple>-->
                <div id="deletedfiles" style="display:none"></div>
                <div id="newfiles" style="display:none;"/></div>
                <table id="myFiles">
                    <thead></thead>
                    <tbody>
                    </tbody>
                </table>
            </fieldset>
        </form>
        <form id="fileform" action="upload_multi_file.php" enctype="multipart/form-data" method="post">
            <label for="file">Filename:</label>
            <span id="upload">
                <input type="file" name="file[]" id="file" multiple style="visibility:hidden;position:absolute;top:0;left:0"/>
                <input type="button" id="btnsubmit" name="btnsubmit" value="Upload" />
            </span>
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
            deleted_files = $("#deletedfiles"),
            new_files = $("#newfiles"),
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
            function clearDialogFields() {
                notice_title.val('');
                notice_txt.val('');
                deleted_files.val('');
                new_files.val('');
                //$("#myFiles").find("tr").remove();
            }
            
            $( "#dialog-add-notice" ).dialog({
                autoOpen: false,
                height: 450,
                width: 550,
                modal: true,
                buttons: {
                    "Save notice": function() {
                        deleteUnwantedFilesFromDialog();
                        var edit_notice_id = $("#idedit").val();
                        var alreadyAttachedFileStr = "";
                        var alreadyAttachedFiles = "";
                        if(edit_notice_id > 0) {
                            deleteFileFromNoticeAttachmentCell(edit_notice_id);
                            alreadyAttachedFileStr = $( "#attachedfiles"+edit_notice_id ).val();
                        }
                        if(alreadyAttachedFileStr.charAt(alreadyAttachedFileStr.length-1)== ',') {
                            alreadyAttachedFileStr = alreadyAttachedFileStr.substr(0, alreadyAttachedFileStr.length-1);
                        }
                        var fileArray = alreadyAttachedFileStr.split(',');
                        var i ;
                        for(i = 0; i < fileArray.length; i++) {
                            var fileValues = fileArray[i].split('|');
                            var fileId = fileValues[0];
                            if(i != 0) {
                                alreadyAttachedFiles +=  ',';
                            }
                            alreadyAttachedFiles += fileId;
                        }
                        var attached_new_file_ids = getAttachedNewFileIDs();
                        var attachedFiles = "";
                        
                        if(alreadyAttachedFiles != "") {
                            attachedFiles = alreadyAttachedFiles;
                            if(attached_new_file_ids != "")
                                attachedFiles += ","+attached_new_file_ids;
                        } else {
                            if(attached_new_file_ids != "")
                                attachedFiles = attached_new_file_ids;
                        }
                        
                        allFields.removeClass( "ui-state-error" );
                        if(notice_title.val().length==0) {
                            updateTips("Title should not be empty");
                        } else if(notice_txt.val().length==0) {
                            updateTips("Description should not be empty");
                        } else {
                            var dataString = "notice_title=" + notice_title.val() + "&notice_text="+notice_txt.val()+"&delete_notice_id=0"+"&edit_notice_id="+edit_notice_id+"&attached_files="+attachedFiles;
                            var thisdialog = this;
                            $.ajax({  
                                type: "POST",  
                                url: "savenotice.php",  
                                data: dataString,
                                success: function(response){
                                    if(response > 0) {
                                        $( "#notices tbody" ).append( getNoticeRowString(response, notice_title.val(), notice_txt.val() ) );
                                        clearDialogFields();
                                        $( thisdialog ).dialog( "close" );
                                    } else if(response=="success"){
                                        $( "#tdtitle"+edit_notice_id ).text( notice_title.val() );
                                        $( "#tdtext"+edit_notice_id ).text( notice_txt.val() );
                                        addNewFilesToNoticeAttachmentCell(edit_notice_id);
                                        clearDialogFields();
                                        $( thisdialog ).dialog( "close" );
                                    } else {
                                        updateTips("Database error, could not save notice.");
                                    }
                                }  
                            });

                        }
                    },
                    Cancel: function() {
                        clearDialogFields();
                        $( this ).dialog( "close" );
                    }
                },
                close: function() {
                    clearDialogFields();
                    allFields.val( "" ).removeClass( "ui-state-error" );
                }
            });

            $( "#add-notice" ).button().click(function() {
                $("#idedit").val(0)
                $("#dialog-add-notice" ).dialog( "open" );
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
                                    alert("Database error, could not delete notice. "+response);
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
            
            // --------------------------------------
            // + File upload:
            $("#btnsubmit").click(function () {
                    submitfile();
            });

            $('input[type=file]').change(function(e){
                //var formData = new FormData($("#fileform")[0]);
                //var formData = $('#fileform').formSerialize();

                $('#fileform').ajaxSubmit({
                        target: '#newfiles',
                        success:  afterSuccess //call function after success
                });
            });
            // - File upload
            // --------------------------------------
                                    
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