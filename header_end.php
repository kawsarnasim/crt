<div id="search_location_bar">
    <div id="current_location">
        <table><tr><td><span class=" icon ui-icon ui-icon-info"></span></td><td>This site is under construction</td></tr></table>
    </div>
    <div id="page_headersearch">
        
        <form>
            <div>
                <input type="text" class="searchtext" />
                <input type="button" value="Search" class="button" onclick="search()"/>
                
                <div class="clearthis">&nbsp;</div>
            </div>
        </form>

    </div>
</div>

<!-- Start of Left Sidebar -->

<div id="left_sidebar">


    <!-- Start of Categories Box -->

    <div id="categories">

        <div class="first">
            <a  onclick="javascript:toggle_visibility('about_crt')">About CRT</a><br />
            <div style="display: inline;" id="about_crt">
                <ul>
                    <li>
                        <a href="whoweare.php">Who we are</a>
                    </li>
                    <li>
                        <a href="mission.php">Vision & Mission</a>
                    </li>
                    <li class="last">
                        <a href="values.php">Values</a>
                    </li>
                </ul>
            </div>
        </div>

        <div><a href="vacancy.php">Vacancy</a></div>
        <div><a href="photogallery.php">Photo Gallery</a></div>
        
        <div><a href="downloads.php">Downloads</a></div>
        <?php
        if ($usertype == 1 || $usertype == 2) {
            ?>
            <div>
                <a  onclick="javascript:toggle_visibility('admin_panel')">Admin Panel</a><br />
                <div style="display: inline;" id="admin_panel">
                    <ul>
                        <li>
                            <a href="noticesettings.php">Notice Settings</a>
                        </li>
                        <li>
                            <a href="publicationsettings.php">Publication Settings</a>
                        </li>
                        <li>
                            <a href="researchsettings.php">Research Settings</a>
                        </li>
                        <li>
                            <a href="trainingsettings.php">Training Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div><a href="contact-us.php">Contact Us</a></div>
            <?php
        }
        ?>
            
        <?php
        if (!$loggedin) {
            ?>
            <div class="last"><a href="login.php">Sign in</a></div>
<!--            <input type="button" value="Login" class="button" onclick="login()"/>-->
            <?php
        } else {
            ?>
            <div class="last"><a href="logout.php">Sign out</a></div>
<!--            <input type="button" value="Logout" class="button" onclick="logout()"/>-->
            <?php
        }
        ?>


        <!--			<div class="clearthis">&nbsp;</div>-->
    </div>
    <!-- End of Categories Box -->


</div>

<!-- End of Left Sidebar -->
