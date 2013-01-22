<?php

require_once("./include/data/noticeinfo.php");

include "dbconnect.php";

class Notice extends DBConnect{
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;

    //-----Initialization -------
    function Notice() {
        parent::DBConnect();
        $this->connection="";
    }
    
    function getAllNotices() {
        
        $noticeInfoArray = array();
        $this->connection=$this->ConnectDB();
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $noticeInfoArray;
        }
        $qry = "SELECT * FROM notices";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $noticeInfoArray;
        }
        
        while( $row = mysql_fetch_array($result) ) {
            $noticeInfo = new NoticeInfo();
            $noticeInfo->setId($row['id_notice']);
            $noticeInfo->setTitle($row['notice_title']);
            $noticeInfo->setText($row['notice_text']);
            $noticeInfo->setCreationDateTime($row['creationdatetime']);
            $noticeInfo->setUpdateDateTime($row['lastupdatedatetime']);
            
            $noticeInfoArray[]=$noticeInfo;
        }

        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $noticeInfoArray;
        
    } // End of getAllNotices() method
    
    /**
     * Create a new Notice in the Database.
     */
    function createNotice($title, $text) {
        $id_notice = 0;
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_notice;
        }
        
        $qry =  "INSERT INTO notices (notice_title, notice_text, creationdatetime, lastupdatedatetime)"
                ." VALUES ('$title', '$text', CURDATE(), CURDATE());";
        
        if(!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_notice;
        }
        
        $id_notice = mysql_insert_id($this->connection);
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $id_notice;
    }
    
    /**
     * Delete a specific notice from database
     */
    function deleteNotice($id_notice) {
        
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        
        $qry =  "DELETE FROM notices WHERE id_notice=$id_notice";
        
        if(!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
                
        return "success";
    }
    
    /**
     * Update a notice in the database
     */
    function updateNotice($id_notice, $notice_title, $notice_text) {
        
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        
        $qry =  "UPDATE notices SET notice_title='$notice_title', notice_text='$notice_text' WHERE id_notice=$id_notice";
        
        if(!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
                
        return "success";
    }
    
}
?>
