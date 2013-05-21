<?PHP

include("properties.php");
require_once("./include/fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('crtbd.org');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('admin@crtbd.org');

//Provide the email address where you want to get contact notifications
$fgmembersite->SetInfoEmail('info@crtbd.org');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, members in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB($dbhost, $dbusername, $dbpwd, $dbname, 'users');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('qSRcVS6DrTzrPvr');
?>