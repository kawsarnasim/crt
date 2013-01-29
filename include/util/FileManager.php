<?php

require_once("./include/data/fileinfo.php");

include "dbconnect.php";

class FileManager extends DBConnect {

    function FileManager() {
        parent::DBConnect();
        $this->connection = "";
    }
    
    function getFile($fileid) {
        $fileInfo = NULL;
        $this->connection = $this->ConnectDB();
        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfo;
        }
        $qry = "SELECT * FROM files where id_file=$fileid";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfoArray;
        }

        $row = mysql_fetch_array($result);
        $fileInfo = new FileInfo();
        $fileInfo->setId($row['id_file']);
        $fileInfo->setName($row['name']);
        $fileInfo->setType($row['type']);
        $fileInfo->setSize($row['size']);
        $fileInfo->setLocation($row['location']);
        $fileInfo->setUploadDateTime($row['update_date_time']);

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return $fileInfo;
    }

    function getAllFiles() {
        $fileInfoArray = array();
        $this->connection = $this->ConnectDB();
        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfoArray;
        }
        $qry = "SELECT * FROM files";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfoArray;
        }

        while ($row = mysql_fetch_array($result)) {
            $fileInfo = new FileInfo();
            $fileInfo->setId($row['id_file']);
            $fileInfo->setName($row['name']);
            $fileInfo->setType($row['type']);
            $fileInfo->setSize($row['size']);
            $fileInfo->setLocation($row['location']);
            $fileInfo->setUploadDateTime($row['update_date_time']);

            $fileInfoArray[] = $noticeInfo;
        }

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return $fileInfoArray;
    }

// End of getAllNotices() method

    /**
     * Create a new File in the Database.
     */
    function createFile($name, $type, $size, $location, $upload_date_time) {
        $id_file = 0;
        $this->connection = $this->ConnectDB();

        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $id_file;
        }

        $qry = "INSERT INTO files (name, type, size, location, upload_date_time)"
                . " VALUES ('$name', '$type', $size, '$location', CURDATE())";

        if (!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $id_file;
        }

        $id_file = mysql_insert_id($this->connection);

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return $id_file;
    }

    /**
     * Delete a specific file from database
     */
    function deleteFile($id_file) {

        $this->connection = $this->ConnectDB();

        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return "fail";
        }

        $qry = "DELETE FROM files WHERE id_file=$id_file";

        if (!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return "fail";
        }

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return "success";
    }

    /**
     * Update a file in the database
     */
    function updateFile($id_file, $name, $type, $size, $location, $upload_date_time) {

        $this->connection = $this->ConnectDB();

        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return "fail";
        }

        $qry = "UPDATE files SET name='$name', type='$type', size='$size', location='$location', upload_date_time='$upload_date_time'  WHERE id_file=$id_file";

        if (!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return "fail";
        }

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return "success";
    }

}

?>
