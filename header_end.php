<div id="search_location_bar">
    <div id="current_location">
        You are here:
    </div>
    <div id="page_headersearch">
        <h3>Search:</h3>

        <form>
            <div>
                <input type="text" class="searchtext" />
                <input type="button" value="Submit" class="button" onclick="search()"/>
                <?php
                if (!$loggedin) {
                    ?>
                    <input type="button" value="Login" class="button" onclick="login()"/>
                    <?php
                } else {
                    ?>
                    <input type="button" value="Logout" class="button" onclick="logout()"/>
                    <?php
                }
                ?>

                <div class="clearthis">&nbsp;</div>
            </div>
        </form>

    </div>
</div>

<!-- Start of Left Sidebar -->

<div id="left_sidebar">


    <!-- Start of Categories Box -->

    <div id="categories">
        <div id="categories_header">
            <h2>Menu</h2>
        </div>

        <div class="first">
            <a  onclick="javascript:toggle_visibility('about_crt')">About CRT</a><br />
            <div style="display: inline;" id="about_crt">
                <ul>
                    <li>
                        <a href="whoweare.php">Who we are</a>
                    </li>
                    <li>
                        <a href="index.php">Our civics</a>
                    </li>
                    <li>
                        <a href="vision.php">Vision</a>
                    </li>
                    <li>
                        <a href="mission.php">Mission</a>
                    </li>
                    <li>
                        <a href="values.php">Values</a>
                    </li>
                    <li class="last">
                        <a href="index.php">Strategies</a>
                    </li>
                </ul>
            </div>
        </div>

        <div><a href="#">Vacancy</a></div>
        <div><a href="#">Press</a></div>
        <div><a href="#">Photo Gallery</a></div>
        <?php
        if($usertype==1) {
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
                    </ul>
                </div>
            </div>
        <?php
        }
        ?>
        <div><a href="#">Downloads</a></div>
        <?php
        if ($usertype == 1 || $usertype == 2) {
            ?>
            <div class="last"><a href="#">Admin</a></div>
            <?php
        } else {
            ?>
            <div class="last"><a href="#">Contact Us</a></div>
            <?php
        }
        ?>


        <!--			<div class="clearthis">&nbsp;</div>-->
    </div>

    <!-- End of Categories Box -->


</div>

<!-- End of Left Sidebar -->
