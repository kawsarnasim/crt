<?php

/**
 * Notice Data
 */
class NoticeInfo {
    private $id_notice;
    private $notice_title;
    private $notice_text;
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
