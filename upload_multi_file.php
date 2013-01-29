<?php

//echo var_dump($_FILES);
//echo "<br/>";

$num_of_files = count($_FILES["file"]["name"]);
$filestr = "<ul>";
for ($i = 0; $i < $num_of_files; $i = $i + 1) {
    if ($_FILES["file"]["error"][$i] > 0) {
        $filestr .=  "<li>" . "Error: " . $_FILES["file"]["error"][$i] . "</li>";
    } else {               
        //echo "Stored in: " . $_FILES["file"]["tmp_name"][$i]."<br>";
        
        if (file_exists("upload/" . $_FILES["file"]["name"][$i])) {
            $filestr .=  "<li>" . $_FILES["file"]["name"][$i] . " already exists. ". "</li>";
        } else {
            move_uploaded_file($_FILES["file"]["tmp_name"][$i], "uploads/" . $_FILES["file"]["name"][$i]);
            $filestr .=  "<li>" . $_FILES["file"]["name"][$i] . "|"
                . $_FILES["file"]["type"][$i] . "|"
                . $_FILES["file"]["size"][$i] . "|"
                . $_SERVER['SERVER_NAME'] ."/uploads/" . $_FILES["file"]["name"][$i]
                . "</li>";
        }
        
    }
}
$filestr .= "</ul>";

echo $filestr;
?> 