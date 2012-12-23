<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
        <title>An Access Controlled Page</title>
    </head>
    <body>

        <?PHP
        require_once("./include/membersite_config.php");

        if (!$fgmembersite->CheckLogin()) {
            $fgmembersite->RedirectToURL("login.php");
            exit;
        }
        ?>
        <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css"/>
        
        <div id='fg_membersite_content'>
            <h2>This is an Access Controlled Page</h2>
            This page can be accessed after logging in only. To make more access controlled pages, 
            copy paste the code between &lt;?php and ?&gt; to the page and name the page to be php.
            <p>
                <?php
                if ($fgmembersite->UserType() == 1) {
                    echo "<b>(Admin)</b><br/>";
                } else if ($fgmembersite->UserType() == 2) {
                    echo "<b>(Sub-Admin)</b><br/>";
                } else if ($fgmembersite->UserType() == 3) {
                    echo "<b>(Trainee)</b><br/>";
                }
                ?>
                Logged in as: <?php echo $fgmembersite->UserFullName() ?>
            </p>
            <p>
                <a href='login-home.php'>Home</a>
            </p>
        </div>
    </body>
</html>
