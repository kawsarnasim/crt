<?php
include 'header2.php';
?>
<!-- Start of Main Content Area -->

<div id="main_content" align="center">

<?PHP
//require_once("./include/membersite_config.php");

if (!$loggedin) {
    if (isset($_POST['submitted'])) {
        if ($fgmembersite->RegisterUser()) {
            $fgmembersite->RedirectToURL("thank-you.php");
        } else {
            $fgmembersite->RedirectToURL("index.php");
        }
        exit;
    }
    ?>
    <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css" />
    <script type='text/javascript' src='js/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="css/pwdwidget.css" />
    <script src="js/pwdwidget.js" type="text/javascript"></script>

    <!-- Form Code Start -->
    <div id='fg_membersite' align="center">
        <form id='register' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
            <fieldset >
                <legend>Register</legend>

                <input type='hidden' name='submitted' id='submitted' value='1'/>

                <div class='short_explanation'>* required fields</div>
                <input type='text'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

                <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                <div class='container'>
                    <label for='name' >Your Full Name*: </label><br/>
                    <input type='text' name='name' id='name' value='<?php echo $fgmembersite->SafeDisplay('name') ?>' maxlength="50" /><br/>
                    <span id='register_name_errorloc' class='error'></span>
                </div>
                <div class='container'>
                    <label for='email' >Email Address*:</label><br/>
                    <input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
                    <span id='register_email_errorloc' class='error'></span>
                </div>
                <div class='container'>
                    <label for='username' >UserName*:</label><br/>
                    <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
                    <span id='register_username_errorloc' class='error'></span>
                </div>
                <div class='container' style='height:80px;'>
                    <label for='password' >Password*:</label><br/>
                    <div class='pwdwidgetdiv' id='thepwddiv' ></div>
                    <noscript>
                    <input type='password' name='password' id='password' maxlength="50" />
                    </noscript>    
                    <div id='register_password_errorloc' class='error' style='clear:both'></div>
                </div>

                <div class='container'>
                    <input type='submit' name='Submit' value='Submit' />
                </div>

            </fieldset>
        </form>
        <!-- client-side Form Validations:
        Uses the excellent form validation script from JavaScript-coder.com-->

        <script type='text/javascript'>
            // <![CDATA[
            var pwdwidget = new PasswordWidget('thepwddiv','password');
            pwdwidget.MakePWDWidget();
        
            var frmvalidator  = new Validator("register");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();
            frmvalidator.addValidation("name","req","Please provide your name");

            frmvalidator.addValidation("email","req","Please provide your email address");

            frmvalidator.addValidation("email","email","Please provide a valid email address");

            frmvalidator.addValidation("username","req","Please provide a username");
        
            frmvalidator.addValidation("password","req","Please provide a password");

            // ]]>
        </script>

    </div>
    <!--
    Form Code End (see html-form-guide.com for more info.)
    -->
    <?php
} else
if ($loggedin) {
    echo "<br/><p>login stat:  loggedin </p>";
    $fgmembersite->RedirectToURL("index.php");
}
?>
<?php
include 'footer.php';
?>