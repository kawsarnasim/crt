<?php

require_once(dirname(dirname(__FILE__)).'/data/noticeinfo.php');
include "dbconnect.php";

class Notice extends DBConnect{

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
            
            $fileIds = preg_split("/[\s,]+/", $row['attached_file_ids']);
            $fileIds = array_unique($fileIds);
            foreach($fileIds as $fileid) {
                $noticeInfo->addFile($fileid);
            }
            
            $noticeInfo->setCreationDateTime($row['creationdatetime']);
            $noticeInfo->setUpdateDateTime($row['lastupdatedatetime']);
            
            $noticeInfoArray[]=$noticeInfo;
        }

        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $noticeInfoArray;
        
    } // End of getAllNotices() method
    
    function getNoticeInfo($noticeId) {
        $noticeInfo = NULL;
        $this->connection=$this->ConnectDB();
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $noticeInfo;
        }
        $qry = "SELECT * FROM notices WHERE id_notice=$noticeId";
        $result = mysql_query($qry, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $noticeInfo;
        }
        
        $row = mysql_fetch_array($result);
        
        $noticeInfo = new NoticeInfo();
        $noticeInfo->setId($row['id_notice']);
        $noticeInfo->setTitle($row['notice_title']);
        $noticeInfo->setText($row['notice_text']);

        $fileIds = preg_split("/[\s,]+/", $row['attached_file_ids']);
        $fileIds = array_unique($fileIds);
        foreach($fileIds as $fileid) {
            $noticeInfo->addFile($fileid);
        }

        $noticeInfo->setCreationDateTime($row['creationdatetime']);
        $noticeInfo->setUpdateDateTime($row['lastupdatedatetime']);

        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $noticeInfo;
        
    }
        
    /**
     * Create a new Notice in the Database.
     * @param type $attachmentFileIds string of comma seperated file ids
     * @return int the notice id
     */
    function createNotice($title, $text,$attachmentFileIds) {
        $id_notice = 0;
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_notice;
        }
        
        if($attachmentFileIds == NULL ) {
            $attachmentFileIds ="";
        }
        $qry =  "INSERT INTO notices (notice_title, notice_text, attached_file_ids, creationdatetime, lastupdatedatetime)"
                ." VALUES ('$title', '$text', '$attachmentFileIds', CURDATE(), CURDATE());";
        
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
        $noticeInfo = $this->getNoticeInfo($id_notice);
        if($noticeInfo==NULL) {
            return "fail";
        }
        
        /** Delete attached files from database **/
        $attachedFileIds = $noticeInfo->getFileIDs();
        $this->deleteAttachedFiles($attachedFileIds);
        
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
            //return "fail";
            return "fail";
        }
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
                
        return "success";
    }
    
    /**
     * Delete a group of files from database with the fileIDs provided
     * @param type $fileIds string of comma seperated file ids
     * @return type 
     */
    function deleteAttachedFiles($fileIds) {

        if(strcmp($fileIds, "")==0) {
            return FALSE;
        }
        
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
     * Update a notice in the database
     * @param type $id_notice
     * @param type $notice_title
     * @param type $notice_text
     * @param type $fileids string of comma-seperated file ids
     * @return type 
     */
    function updateNotice($id_notice, $notice_title, $notice_text, $fileids) {
        
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        
        if($fileids==NULL) {
            $qry =  "UPDATE notices SET notice_title='$notice_title', notice_text='$notice_text', lastupdatedatetime=CURDATE() WHERE id_notice=$id_notice";
        } else {
            $qry =  "UPDATE notices SET notice_title='$notice_title', notice_text='$notice_text', attached_file_ids='$fileids', lastupdatedatetime=CURDATE() WHERE id_notice=$id_notice";
        }
        
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
