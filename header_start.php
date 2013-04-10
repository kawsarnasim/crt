<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" />

        <title>
            Center for Research and Training
        </title>


        <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/photoflash.css"/>
        <link rel="stylesheet" href="css/cupertino/jquery-ui-1.8.23.custom.css" />
        
        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script src="js/jquery-ui-1.8.23.custom.min.js"></script>
        <script type="text/javascript" src="js/header-image-slide.js"></script>

        <script type="text/javascript">
            
            $(document).ready(function() {

                $("li.dropdown").mouseenter(function(){
                    $(this).find(".page_menu_dropdown").show();
                    //alert($(this).find(".page_menu_dropdown").text());
                });
                
                $("ul.page_menu_dropdown").mouseenter(function(){
                    $(this).show();
                    //alert($(this).find(".page_menu_dropdown").text());
                });

                $("li.dropdown").mouseleave(function(){
                    $(this).find(".page_menu_dropdown").hide();
                });
                
            });
            
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                $(e).toggle(300);
            }
            function hide_item(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'inline')
                    e.style.display = 'none';
            }
            function search() {
                alert('Search not activated yet');
            }
            function login() {
                document.location =  'login.php';
            }
            function logout() {
                document.location =  'logout.php';
            }
            
        </script>
    </head>

    <body>

        <div id="container" align="center">

            <!-- Start of Page Header -->

            <div id="page_header">

                <div id="page_heading">
                    <img src="images/heading/crtheading.png" height="150px" width="825px"/>
                    <img id="globe" src="images/heading/spinning_globe.gif" height="125px" width="125px"/>
                </div>

                <div class="clearthis">&nbsp;</div>

            </div>

            <!-- End of Page Header -->


            <!-- Start of Page Menu -->

            <div id="page_menu">

                <ul class="level1">
                    <li class="first"><a href="index.php">Home</a></li>
<!--                    <li><a href="views/research.php">Research</a></li>-->
                    <li class="dropdown">
                        <a href="">Research</a>
                        <ul class="page_menu_dropdown" style="position: absolute;display:none;">
                            <li><a href="research.php?rtype=ongoing">Ongoing</a></li>
                            <li><a href="research.php?rtype=completed">Completed</a></li>
                            <li><a href="research.php?rtype=upcoming">Upcoming</a></li>                                
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="">Training</a>
                        <ul class="page_menu_dropdown" style="position: absolute;display:none;">
                            <li><a href="training.php?ttype=ongoing">Ongoing</a></li>
                            <li><a href="training.php?ttype=completed">Completed</a></li>
                            <li><a href="training.php?ttype=upcoming">Upcoming</a></li>                                
                        </ul>
                    </li>
                    <li><a href="views/consultancy.php">Consultancy</a></li>
                    <li><a href="views/staff.php">Staff</a></li>
                    <li><a href="views/advisors.php">Advisors</a></li>
                    <li><a href="views/webmail.php">Webmail</a></li>
                    <li class="last"><a href="register.php">Online Registration</a></li>
                </ul>

            </div>

            <!-- End of Page Menu -->