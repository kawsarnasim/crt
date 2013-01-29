<?php

class FileInfo {

    private $id_file;
    private $name;
    private $type;
    private $size;
    private $location;
    private $fileids;
    private $upload_date_time;

    function FileInfo() {
        $this->fileids = array();
    }

    public function getId() {
        return $this->id_file;
    }

    public function setId($id) {
        $this->id_file = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getLocation() {
        return $this->size;
    }

    public function setLocation($location) {
        $this->location = $location;
    }
    
    public function addFiles($fileIds) {
        $this->fileids[] = $fileIds;
    }
    
    public function getFiles() {
        return $this->fileids;
    }

    public function getUploadDateTime() {
        return $this->upload_date_time;
    }

    public function setUploadDateTime($upload_date_time) {
        $this->upload_date_time = $upload_date_time;
    }

}

?>