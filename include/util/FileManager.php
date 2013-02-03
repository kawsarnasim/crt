<?php
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/data/fileinfo.php'); 
//require_once("../data/fileinfo.php");

require_once("dbconnect.php");

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
            return $fileInfo;
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

    /**
     * Returns the files with the provided file IDs
     * @param type $fileIdArray array of file IDs
     * @return array 
     */
    function getAllFiles($fileIdArray) {
        $fileInfoArray = array();
        
        if( count($fileIdArray) == 0 ) {
            return $fileInfoArray;
        }
        $this->connection = $this->ConnectDB();
        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfoArray;
        }
        $fileIdStr = "";
        if(count($fileIdArray)>0) {
            $i = 0;
            for($i = 0; $i < count($fileIdArray)-1 ; $i++) {
                $fileIdStr .= $fileIdArray[$i].", ";
            }
            $fileIdStr .= $fileIdArray[$i];
        }
        
        $qry = "SELECT * FROM files WHERE id_file in ($fileIdStr)";
        
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
    
    function getLocation($fileid) {
        $location = "";
        $this->connection = $this->ConnectDB();
        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $location;
        }
        $qry = "SELECT location FROM files where id_file=$fileid";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $location;
        }

        $row = mysql_fetch_array($result);
        $location = $row['location'];

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return $location;
    }

    /**
     * Create a new File in the Database.
     */
    function saveFile($name, $type, $size, $location) {
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
            return FALSE;
        }

        $qry = "DELETE FROM files WHERE id_file=$id_file";

        if (!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return FALSE;
        }

        try {
            $this->CloseConnectionDB();
        } catch (Exception $exc) {
            
        }

        return TRUE;
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
