<?php
include 'header2.php';
?>

<div id="main_content" align="center">

    <?PHP
    //require_once("./include/membersite_config.php");

    if (!$loggedin) {
        if (isset($_POST['submitted'])) {
            if ($fgmembersite->Login()) {
                $fgmembersite->RedirectToURL("index.php");
                exit;
            } else {
                echo "<font color=#FF0000><b>" . $fgmembersite->GetErrorMessage() . "</b></font>";
            }
        }
        ?>

        <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css" />
        <script type='text/javascript' src='js/gen_validatorv31.js'></script>

        <!-- Form Code Start -->
        <div id='fg_membersite'>
            <form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
                <fieldset >
                    <legend>Login</legend>

                    <input type='hidden' name='submitted' id='submitted' value='1'/>

                    <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                    <div class='container'>
                        <label for='username' >UserName:</label><br/>
                        <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
                        <span id='login_username_errorloc' class='error'></span>
                    </div>
                    <div class='container'>
                        <label for='password' >Password:</label><br/>
                        <input type='password' name='password' id='password' maxlength="50" /><br/>
                        <span id='login_password_errorloc' class='error'></span>
                    </div>

                    <div class='container'>
                        <input type='submit' name='Submit' value='Submit' />
                    </div>
                    <div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
                </fieldset>
            </form>
            <!-- client-side Form Validations:
            Uses the excellent form validation script from JavaScript-coder.com-->

            <script type='text/javascript'>
                $(function() {
                    $("#username").focus();
                });
                        
                // <![CDATA[

                var frmvalidator  = new Validator("login");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("username","req","Please provide your username");

                frmvalidator.addValidation("password","req","Please provide the password");

                // ]]>
            </script>
        </div>
        <!--
        Form Code End (see html-form-guide.com for more info.)
        -->

        <?php
    } else if ($loggedin) {
        $fgmembersite->RedirectToURL("index.php");
    }
    ?>

    <?php
    include 'footer.php';
    ?>