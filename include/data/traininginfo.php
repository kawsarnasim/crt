<?php

/**
 * Training Data
 */
class TrainingInfo {
    private $id;
    private $title;
    private $description;
    private $status;
    private $createDateTime;
    private $updateDateTime;
    
    function TrainingInfo() {
        
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($rid) {
        $this->id = $rid;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($rtitle) {
        $this->title = $rtitle;
    }
    
    public function getDesrciption() {
        return $this->description;
    }
    
    public function setDescription($rdescription) {
        $this->description = $rdescription;
    }
    
    public function getStatus() {
        return $this->status;
    }
    
    public function setStatus($rstatus) {
        $this->status = $rstatus;
    }
    
    public function getCreationDateTime() {
        return $this->createDateTime;
    }
    
    public function setCreationDateTime($rcreatedatetime) {
        $this->createDateTime = $rcreatedatetime;
    }
    
    public function getUpdateTime() {
        return $this->updateDateTime;
    }
    
    public function setUpdateTime($rupdatetime) {
        $this->updateDateTime = $rupdatetime;
    }
    
}
?>
