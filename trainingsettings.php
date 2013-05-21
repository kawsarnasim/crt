<?php
require_once("properties.php");
require_once("./include/util/training.php");

include 'header2.php';
?>

<?php
if ($loggedin && $usertype == 1) { // Page content can be accessed only if loggedin as admin
    $training = new Training();
    $training->InitDB($dbhost, $dbusername, $dbpwd, $dbname);
    $allTrainings = $training->getAllTrainings();
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
            input.datepicker{ width: 200px;}
        </style>

        <!--    <script src="js/jquery.form.js"></script>-->

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
                
                        
            function getTrainingRowString(id, ttl, txt, startdt, enddt) {
                var str =
                    '<tr id="tr'+id+'">' +
                    '<td id="tdtitle'+id+'" style="width: 25%;">'+ttl+'</td>' +
                    '<td id="tdtext'+id+'">'+txt+'</td>' +
                    '<td id="tdstartdt'+id+'">'+startdt+'</td>' +
                    '<td id="tdenddt'+id+'">'+enddt+'</td>' +
                    '<td style="width: 10px;">' +
                    '<span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editTraining(' + id + ')"></span>' +
                    '</td>' +
                    '<td style="width: 10px;">' +
                    '<span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteTraining(' + id + ')"></span>' +
                    '</td>' +
                    '</tr>';
                return str;
            }
                
            function deleteTraining(id) {
                $( "#iddelete" ).val(id);
                $( "#dialog-confirm-delete" ).dialog( "open" );
            }

            function editTraining(id) {
                $( "#idedit" ).val(id);
                    
                $( "#rtitle" ).val(  $( "#tdtitle"+id ).text() );
                $( "#rtext" ).val(  $( "#tdtext"+id ).text() );
                var startdt;
                var enddt;
                try {
                    startdt = $.datepicker.parseDate('dd/mm/yy', $( "#tdstartdt"+id ).text() );
                    startdt = $.datepicker.formatDate( "dd/mm/yy", startdt);
                    enddt = $.datepicker.parseDate('dd/mm/yy', $( "#tdenddt"+id ).text() );
                    enddt = $.datepicker.formatDate( "dd/mm/yy", enddt);
                } catch(err) {
                    alert("error: "+err);
                }
                $( "#startdt" ).val( startdt.valueOf()  );
                $( "#enddt" ).val( enddt.valueOf()  );
                    
                                
                $( "#dialog-add-training" ).dialog( "open" );
            }
                
        </script>

        <div class="topic">
            <div class="topic_head">
                Training Settings
            </div>
            <div>
                <table id="trainings">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Title</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="training">
                        <?php
                        foreach ($allTrainings as $trainingInfo) {
                            $startdt = new DateTime($trainingInfo->getStartDate());
                            $enddt = new DateTime($trainingInfo->getEndDate());
                            ?>
                            <tr id="tr<?php echo $trainingInfo->getId(); ?>">
                                <td id="tdtitle<?php echo $trainingInfo->getId() ?>" style="width: 25%;"><?php echo $trainingInfo->getTitle(); ?></td>
                                <td id="tdtext<?php echo $trainingInfo->getId() ?>"><?php echo $trainingInfo->getDescription(); ?></td>
                                <td id="tdstartdt<?php echo $trainingInfo->getId() ?>"><?php echo $startdt->format('d/m/Y'); ?></td>
                                <td id="tdenddt<?php echo $trainingInfo->getId() ?>"><?php echo $enddt->format('d/m/Y'); ?></td>
                                <td style="width: 10px;">
                                    <span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editTraining('<?php echo $trainingInfo->getId(); ?>')"></span>
                                </td>
                                <td style="width: 10px;">
                                    <span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteTraining('<?php echo $trainingInfo->getId(); ?>')"></span>
                                </td>
                            </tr>                
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
                <button id="add-training">Add training</button>
            </div>
        </div>

        <div id="dialog-add-training" title="Add new training">
            <p class="validateTips"></p>
            <form id="frmtraininginfo" action="upload_multi_file.php" enctype="multipart/form-data" method="post">

                <fieldset>
                    <label for="rtitle">Title</label>
                    <input type="text" name="rtitle" id="rtitle" class="text ui-widget-content ui-corner-all" /><br/>

                    <label for="rtext">Text</label>
                    <textarea rows="8" type="text" name="rtext" id="rtext" class="text ui-widget-content ui-corner-all" ></textarea><br/>

                    <label for="startdt">Start Date</label>
                    <input type="text" name="startdt" id="startdt" class="datepicker text ui-widget-content ui-corner-all" /><br/>

                    <label for="enddt">End Date</label>
                    <input type="text" name="enddt" id="enddt" class="datepicker text ui-widget-content ui-corner-all" /><br/>
                </fieldset>

            </form>
        </div>

        <input type="hidden" id="iddelete" name="iddelete" value="0" />
        <div id="dialog-confirm-delete" title="Delete this training item?">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The training item will be permanently deleted and cannot be recovered. Are you sure?</p>
        </div>

        <input type="hidden" id="idedit" name="idedit" value="0" />


        <script>
            $(function() {
                $( ".datepicker" ).datepicker();
                    
                var training_title = $( "#rtitle" ),
                training_txt = $( "#rtext" ),
                training_startdate = $("#startdt"),
                training_enddate = $("#enddt"),
                    
                allFields = $( [] ).add( training_title ).add( training_txt ).add(training_startdate).add(training_enddate),
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
                    training_title.val('');
                    training_txt.val('');
                    training_startdate.val('');
                    training_enddate.val('');
                }
                    
                $( "#dialog-add-training" ).dialog({
                    autoOpen: false,
                    height: 450,
                    width: 550,
                    modal: true,
                    buttons: {
                        "Save training": function() {
                            var edit_training_id = $("#idedit").val();
                            var startdate = $.datepicker.formatDate( "yy-mm-dd", $(training_startdate).datepicker('getDate') );
                            var enddate = $.datepicker.formatDate( "yy-mm-dd", $(training_enddate).datepicker('getDate') );
                                
                            var startdatedisplay = $.datepicker.formatDate( "dd/mm/yy", $(training_startdate).datepicker('getDate') );
                            var enddatedisplay = $.datepicker.formatDate( "dd/mm/yy", $(training_enddate).datepicker('getDate') );
                                
                            allFields.removeClass( "ui-state-error" );
                            if(training_title.val().length==0) {
                                updateTips("Title should not be empty");
                            } else if(training_txt.val().length==0) {
                                updateTips("Description should not be empty");
                            } /*else if(startdate.valueOf().length==0) {
                                updateTips("Start date should not be empty");
                            } else if(enddate.valueOf().length==0) {
                                updateTips("End date should not be empty");
                            }*/ else {
                                var dataString = "training_title=" + training_title.val() + "&training_text="+training_txt.val()+"&delete_training_id=0"+"&edit_training_id="+edit_training_id+"&start_date="+startdate.valueOf()+"&end_date="+enddate.valueOf();
                                var thisdialog = this;
                                $.ajax({  
                                    type: "POST",  
                                    url: "savetraining.php",  
                                    data: dataString,
                                    success: function(response){
                                        if(response > 0) {
                                            $( "#trainings tbody.training" ).append( getTrainingRowString(response, training_title.val(), training_txt.val(), startdatedisplay.valueOf(), enddatedisplay.valueOf() ));
                                            clearDialogFields();
                                            $( thisdialog ).dialog( "close" );
                                        } else if(response=="success"){
                                            $( "#tdtitle"+edit_training_id ).text( training_title.val() );
                                            $( "#tdtext"+edit_training_id ).text( training_txt.val() );
                                            $( "#tdstartdt"+edit_training_id ).text( startdatedisplay.valueOf() );
                                            $( "#tdenddt"+edit_training_id ).text( enddatedisplay.valueOf() );
                                            clearDialogFields();
                                            $( thisdialog ).dialog( "close" );
                                        } else {
                                            updateTips("Database error, could not save training.");
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

                $( "#add-training" ).button().click(function() {
                    $("#idedit").val(0)
                    $("#dialog-add-training" ).dialog( "open" );
                });
                    
                $( "#dialog-confirm-delete" ).dialog({
                    autoOpen: false,
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                        "Delete training": function() {
                            var deleteid = $("#iddelete").val();
                            var dataString = "training_title=" + "&training_text="+"&delete_training_id=" + deleteid + "&edit_training_id=0"+"&start_date=&end_date=";
                            var thisdialog = this;
                            $.ajax({  
                                type: "POST",  
                                url: "savetraining.php",  
                                data: dataString,
                                success: function(response){  
                                    if(response == "success") {
                                        removeTableRow( deleteid );
                                    } else {
                                        alert("Database error, could not delete training. "+response);
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