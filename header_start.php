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

        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/header-image-slide.js"></script>

        <script type="text/javascript">
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                $(e).toggle(300);
            }
            function hide_item(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'inline')
                    e.style.display = 'none';
            }
        </script>
    </head>

    <body>

        <div id="container">

            <!-- Start of Page Header -->

            <div id="page_header">

                <div id="page_heading">
                    <img src="images/crtheading.png" height="150px" width="825px"/>
                    <img id="globe" src="images/spinning_globe.gif" height="125px" width="125px"/>
                </div>

                <div class="clearthis">&nbsp;</div>

            </div>

            <!-- End of Page Header -->


            <!-- Start of Page Menu -->

            <div id="page_menu">

                <ul>
                    <li class="first"><a href="index.php">Home</a></li>
                    <li><a href="views/research.php">Research</a></li>
                    <li><a href="views/training.php">Training</a></li>
                    <li><a href="views/consultancy.php">Consultancy</a></li>
                    <li><a href="views/staff.php">Staff</a></li>
                    <li><a href="views/advisors.php">Advisors</a></li>
                    <li><a href="views/webmail.php">Webmail</a></li>
                    <li class="last"><a href="register.php">Registration</a></li>
                </ul>

            </div>

            <!-- End of Page Menu -->