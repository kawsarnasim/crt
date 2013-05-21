<?php
require_once("properties.php");
require_once("./include/util/research.php");

include 'header2.php';
?>

<?php
if ($loggedin && $usertype == 1) { // Page content can be accessed only if loggedin as admin
    $research = new Research();
    $research->InitDB($dbhost, $dbusername, $dbpwd, $dbname);
    $allResearches = $research->getAllResearches();
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
                
                        
            function getResearchRowString(id, ttl, txt, startdt, enddt) {
                var str =
                    '<tr id="tr'+id+'">' +
                    '<td id="tdtitle'+id+'" style="width: 25%;">'+ttl+'</td>' +
                    '<td id="tdtext'+id+'">'+txt+'</td>' +
                    '<td id="tdstartdt'+id+'">'+startdt+'</td>' +
                    '<td id="tdenddt'+id+'">'+enddt+'</td>' +
                    '<td style="width: 10px;">' +
                    '<span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editResearch(' + id + ')"></span>' +
                    '</td>' +
                    '<td style="width: 10px;">' +
                    '<span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteResearch(' + id + ')"></span>' +
                    '</td>' +
                    '</tr>';
                return str;
            }
                
            function deleteResearch(id) {
                $( "#iddelete" ).val(id);
                $( "#dialog-confirm-delete" ).dialog( "open" );
            }

            function editResearch(id) {
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
                    
                                
                $( "#dialog-add-research" ).dialog( "open" );
            }
                
        </script>

        <div class="topic">
            <div class="topic_head">
                Research Settings
            </div>
            <div>
                <table id="researches">
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
                    <tbody class="research">
                        <?php
                        foreach ($allResearches as $researchInfo) {
                            $startdt = new DateTime($researchInfo->getStartDate());
                            $enddt = new DateTime($researchInfo->getEndDate());
                            ?>
                            <tr id="tr<?php echo $researchInfo->getId(); ?>">
                                <td id="tdtitle<?php echo $researchInfo->getId() ?>" style="width: 25%;"><?php echo $researchInfo->getTitle(); ?></td>
                                <td id="tdtext<?php echo $researchInfo->getId() ?>"><?php echo $researchInfo->getDescription(); ?></td>
                                <td id="tdstartdt<?php echo $researchInfo->getId() ?>"><?php echo $startdt->format('d/m/Y'); ?></td>
                                <td id="tdenddt<?php echo $researchInfo->getId() ?>"><?php echo $enddt->format('d/m/Y'); ?></td>
                                <td style="width: 10px;">
                                    <span class="icon ui-icon ui-icon-pencil" title="edit" onclick="editResearch('<?php echo $researchInfo->getId(); ?>')"></span>
                                </td>
                                <td style="width: 10px;">
                                    <span class="icon ui-icon ui-icon-trash" title="delete" onclick="deleteResearch('<?php echo $researchInfo->getId(); ?>')"></span>
                                </td>
                            </tr>                
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
                <button id="add-research">Add research</button>
            </div>
        </div>

        <div id="dialog-add-research" title="Add new research">
            <p class="validateTips"></p>
            <form id="frmresearchinfo" action="upload_multi_file.php" enctype="multipart/form-data" method="post">

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
        <div id="dialog-confirm-delete" title="Delete this research item?">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>The research item will be permanently deleted and cannot be recovered. Are you sure?</p>
        </div>

        <input type="hidden" id="idedit" name="idedit" value="0" />


        <script>
            $(function() {
                $( ".datepicker" ).datepicker();
                    
                var research_title = $( "#rtitle" ),
                research_txt = $( "#rtext" ),
                research_startdate = $("#startdt"),
                research_enddate = $("#enddt"),
                    
                allFields = $( [] ).add( research_title ).add( research_txt ).add(research_startdate).add(research_enddate),
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
                    research_title.val('');
                    research_txt.val('');
                    research_startdate.val('');
                    research_enddate.val('');
                }
                    
                $( "#dialog-add-research" ).dialog({
                    autoOpen: false,
                    height: 450,
                    width: 550,
                    modal: true,
                    buttons: {
                        "Save research": function() {
                            var edit_research_id = $("#idedit").val();
                            var startdate = $.datepicker.formatDate( "yy-mm-dd", $(research_startdate).datepicker('getDate') );
                            var enddate = $.datepicker.formatDate( "yy-mm-dd", $(research_enddate).datepicker('getDate') );
                                
                            var startdatedisplay = $.datepicker.formatDate( "dd/mm/yy", $(research_startdate).datepicker('getDate') );
                            var enddatedisplay = $.datepicker.formatDate( "dd/mm/yy", $(research_enddate).datepicker('getDate') );
                                
                            allFields.removeClass( "ui-state-error" );
                            if(research_title.val().length==0) {
                                updateTips("Title should not be empty");
                            } else if(research_txt.val().length==0) {
                                updateTips("Description should not be empty");
                            } /*else if(startdate.valueOf().length==0) {
                                updateTips("Start date should not be empty");
                            } else if(enddate.valueOf().length==0) {
                                updateTips("End date should not be empty");
                            }*/ else {
                                var dataString = "research_title=" + research_title.val() + "&research_text="+research_txt.val()+"&delete_research_id=0"+"&edit_research_id="+edit_research_id+"&start_date="+startdate.valueOf()+"&end_date="+enddate.valueOf();
                                var thisdialog = this;
                                $.ajax({  
                                    type: "POST",  
                                    url: "saveresearch.php",  
                                    data: dataString,
                                    success: function(response){
                                        if(response > 0) {
                                            $( "#researches tbody.research" ).append( getResearchRowString(response, research_title.val(), research_txt.val(), startdatedisplay.valueOf(), enddatedisplay.valueOf() ));
                                            clearDialogFields();
                                            $( thisdialog ).dialog( "close" );
                                        } else if(response=="success"){
                                            $( "#tdtitle"+edit_research_id ).text( research_title.val() );
                                            $( "#tdtext"+edit_research_id ).text( research_txt.val() );
                                            $( "#tdstartdt"+edit_research_id ).text( startdatedisplay.valueOf() );
                                            $( "#tdenddt"+edit_research_id ).text( enddatedisplay.valueOf() );
                                            clearDialogFields();
                                            $( thisdialog ).dialog( "close" );
                                        } else {
                                            updateTips("Database error, could not save research.");
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

                $( "#add-research" ).button().click(function() {
                    $("#idedit").val(0)
                    $("#dialog-add-research" ).dialog( "open" );
                });
                    
                $( "#dialog-confirm-delete" ).dialog({
                    autoOpen: false,
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                        "Delete research": function() {
                            var deleteid = $("#iddelete").val();
                            var dataString = "research_title=" + "&research_text="+"&delete_research_id=" + deleteid + "&edit_research_id=0"+"&start_date=&end_date=";
                            var thisdialog = this;
                            $.ajax({  
                                type: "POST",  
                                url: "saveresearch.php",  
                                data: dataString,
                                success: function(response){  
                                    if(response == "success") {
                                        removeTableRow( deleteid );
                                    } else {
                                        alert("Database error, could not delete research. "+response);
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