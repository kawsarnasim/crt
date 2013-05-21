<?php

/**
 * Training Data
 */
class TrainingInfo {

    private $id;
    private $title;
    private $description;
    private $startDate;
    private $endDate;
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

    public function getDescription() {
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

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($rstartdate) {
        $this->startDate = $rstartdate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($renddate) {
        $this->endDate = $renddate;
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
