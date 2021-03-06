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
    function getAllFiles($fileIdStr) {
        $fileInfoArray = array();
        $this->connection = $this->ConnectDB();
        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return $fileInfoArray;
        }
        $fileIdStr = trim($fileIdStr);
        if(strlen($fileIdStr) > 0 && $fileIdStr[strlen($fileIdStr)-1] == ',') {
           $fileIdStr = substr( $fileIdStr , 0, strlen($fileIdStr)-1);
        } 
        
        if(strcmp($fileIdStr,"") == 0) {
            return $fileInfoArray;
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
            $fileInfo->setUploadDateTime($row['upload_date_time']);

            $fileInfoArray[] = $fileInfo;
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
    
    function deleteFileFromFileSystem($fileid) {
        $location = $this->getLocation($fileid);
        if(strcmp($location, "")==0) {
            return FALSE;
        }
        
        //$st = split("/", $location);
        $st = preg_split("/[\/]/", $location);
        $locationOnDisk = "uploads/".$st[count($st)-1];
        if(!unlink($locationOnDisk)) { // delete from file system only after successful deletion from database
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Delete a group of files from database with the fIDs provided
     * @param type $fileIds string of comma seperated file ids
     * @return type 
     */
    function deleteFiles($fileIds) {

        $this->connection = $this->ConnectDB();

        if ($this->connection == NULL) {
            try {
                $this->CloseConnectionDB();
            } catch (Exception $exc) {
                
            }
            return FALSE;
        }

        $qry = "DELETE FROM files WHERE id_file in ($fileIds)";

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
