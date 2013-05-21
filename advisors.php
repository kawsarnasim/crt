<?php
require_once("./include/membersite_config.php");
$loggedin = FALSE;
$usertype = 3;
if ($fgmembersite->CheckLogin()) {
    $usertype = $fgmembersite->UserType();
    $loggedin = true;
} else {
    $usertype = 3;
}

include 'header2.php';
?>

<div id="main_content" align="center">

    <div class="topic">
        <div class="topic_head">
            Advisors
        </div>

        <div class="topic_body">
            <ul style="margin-left:20px; margin-top:10px; list-style-type:circle;">
                <li>
                    <b>Professor Dr. Abdur Rashid Ahmed </b><br /> 
                    Department of Agricultural Statistics<br />
                    Bangladesh Agricultural University, Mymensingh
                </li>
                <li>
                    <b>Professor Dr. Md. Iqbal Hossain </b><br /> 
                    Department of Agricultural Statistics<br />
                    Bangladesh Agricultural University, Mymensingh
                </li>
                <li>
                    <b>Professor Dr. Md. Kabir Hossain </b><br /> 
                    Director, University Research Centre<br />
                    Shahjalal University of Science & Technology, Sylhet
                </li>
                <li>
                    <b>Professor Dr. Ahmed Kabir </b><br /> 
                    Department of Statistics<br />
                    Shahjalal University of Science & Technology, Sylhet
                </li>
                <li>
                    <b>Professor Ahmed Kabir Chowdhury </b><br /> 
                    Department of Statistics<br />
                    Shahjalal University of Science & Technology, Sylhet
                </li>
                <li>
                    <b>Professor Dr. Md. Azizul Baten </b><br /> 
                    Department of Statistics<br />
                    Shahjalal University of Science & Technology, Sylhet
                </li>
                <li>
                    <b>Professor Noor Md. Rahmatullah  </b><br /> 
                    Department of Agricultural Statistics<br />
                    Sher-E-Bangla Agricultural University, Dhaka
                </li>
                <li>
                    <b>Md. Farouq Imam </b><br /> 
                    Associate Professor<br />
                    Department of Agricultural Statistics<br />
                    Bangladesh Agricultural University, Mymensingh
                </li>
            </ul>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>