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
    
    /**
     * Create a new Notice in the Database.
     */
    function createNotice($title, $text) {
        $id_notice = 0;
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            return $id_notice;
        }
        
        $qry =  "insert into notices (notice_title, notice_text, creationdatetime, lastupdatedatetime)"
                ." values ('$title', '$text', CURDATE(), CURDATE());";
        
        if(!mysql_query($qry, $this->connection)) {
            return $id_notice;
        }
        
        $id_notice = mysql_insert_id($this->connection);
        
        return $id_notice;
    }
    
    function getAllNotices() {
        
        $noticeInfoArray = array();
        $this->connection=$this->ConnectDB();
        if($this->connection==NULL) {
            return $noticeInfoArray;
        }
        $qry = "Select * from notices";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            return $noticeInfoArray;
        }
        
//        while ($row_user = mysql_fetch_assoc($result)) {
//            $noticeInfoArray[] = $row_user;
//        }
        
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
    
}
?>
