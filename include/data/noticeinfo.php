<?php

/**
 * Notice Data
 */
class NoticeInfo {
    private $id_notice;
    private $notice_title;
    private $notice_text;
    private $fileIDs;
    private $creationDateTime;
    private $updateDateTime;
    
    function NoticeInfo() {
        
    }
    
    public function getId() {
        return $this->id_notice;
    }
    
    public function setId($id) {
        $this->id_notice=$id;
    }
    
    public function getTitle() {
        return $this->notice_title;
    }
    
    public function setTitle($title) {
        $this->notice_title=$title;
    }
    
    public function getText() {
        return $this->notice_text;
    }
    
    public function setText($text) {
        $this->notice_text=$text;
    }

    /**
     * Get a comma seperated string of file ids
     * @return type 
     */
    public function getFileIDs() {
        return $this->fileIDs;
    }
    
    /**
     * Creates a comma seperated string of fileids
     * @param type $fileId 
     */
    public function addFile($fileId) {
        if( strcmp($this->fileIDs, "")==0 ) {
            $this->fileIDs=$fileId;
        } else {
            $this->fileIDs .= ",$fileId";
        }
    }

    public function getCreationDateTime() {
        return $this->creationDateTime;
    }
    
    public function setCreationDateTime($dateTime) {
        $this->creationDateTime=$dateTime;
    }
    
    public function getUpdateDateTime() {
        return $this->updateDateTime;
    }
    
    public function setUpdateDateTime($dateTime) {
        $this->updateDateTime=$dateTime;
    }
}
?>
