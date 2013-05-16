<?php
    require_once("properties.php");
    require_once("./include/util/notice.php");
    $notice = new Notice();
    $notice->InitDB( $dbhost, $dbusername, $dbpwd, $dbname);
    $allNotices = $notice->getAllNotices();
?>
    
    
    </div>    
        <div id="right_sidebar">
            <div id="publication">
                <table>
                    <tr>
                        <td class="first"> Publications</td>
                    </tr>
                    <tr>
                        <td>
                            Publication 1
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="noticeboard">
                <table>
                    <tr>
                        <td class="first">
                            Notices
                        </td>
                    </tr>
                    <?php
                    foreach($allNotices as $noticeInfo) {
                    ?>
                    <tr>
                        <td><?php echo $noticeInfo->getTitle(); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>                
            </div>
        </div>


	<div class="clearthis">&nbsp;</div>


	<!-- Start of Page Footer -->

	<div id="page_footer">

		<div id="powered_by">
		Copyright &copy; 2013, Center for Research and Training (CRT)
		</div>

		<div class="clearthis">&nbsp;</div>
	</div>

	<!-- End of Page Footer -->

</div>

</body>
</html>