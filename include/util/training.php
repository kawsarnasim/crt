<?php

require_once(dirname(dirname(__FILE__)).'/data/traininginfo.php');
include "dbconnect.php";

class Training extends DBConnect{
    
    public static $ONGOING = 1;
    public static $COMPLETED = 2;
    public static $UPCOMING = 3;

    //-----Initialization -------
    function Training() {
        parent::DBConnect();
        $this->connection="";
    }
    
    function getAllTrainings() {
        
        $trainingInfoArray = $this->getTrainingsByQuery("SELECT * FROM trainings ORDER BY startdate DESC, enddate DESC, title ASC");
        
        return $trainingInfoArray;        
    }
    
    function getOngoingTrainings() {
        
        $trainingInfoArray = $this->getTrainingsByQuery("SELECT * FROM trainings WHERE startdate <= CURDATE() and enddate >= CURDATE()");
        
        return $trainingInfoArray;        
    }
    
    function getPastTrainings() {
        
        $trainingInfoArray = $this->getTrainingsByQuery("SELECT * FROM trainings WHERE enddate < CURDATE()");
        
        return $trainingInfoArray;        
    }
    
    function getFutureTrainings() {
        
        $trainingInfoArray = $this->getTrainingsByQuery("SELECT * FROM trainings WHERE startdate > CURDATE()");
        
        return $trainingInfoArray;        
    }
    
    function getTrainingInfo($trainingId) {
        
        $trainingInfoArray = $this->getTrainingsByQuery("SELECT * FROM trainings WHERE id=$trainingId");
        
        $trainingInfo = (count($trainingInfoArray)==0) ? NULL : $trainingInfoArray[0];        
        
        return $trainingInfo;        
    }
        
    /**
     * Create a new Training in the Database.
     * @return int the training id
     */
    function createTraining($title, $description, $startDate, $endDate) {
        $id_training = 0;
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_training;
        }
        
        $qry =  "INSERT INTO trainings (title, description, startdate, enddate, creationdatetime, lastupdatetime)"
                ." VALUES ('$title', '$description','$startDate','$endDate', CURDATE(), CURDATE());";
        
        if(!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_training;
        }
        
        $id_training = mysql_insert_id($this->connection);
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $id_training;
    }
    
    /**
     * Delete a specific notice from database
     */
    function deleteTraining($id_training) {
        $trainingInfo = $this->getTrainingInfo($id_training);
        if($trainingInfo==NULL) {
            return "fail";
        }
                
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
                
        $qry =  "DELETE FROM trainings WHERE id=$id_training";
        
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
     * Update a training in the database 
     */
    function updateTraining($id_training, $title, $startDate, $endDate, $desc) {
        
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        $qry =  "UPDATE trainings SET title='$title', description='$desc', startdate='$startDate', enddate= '$endDate', lastupdatetime=CURDATE() WHERE id=$id_training";
               
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
    
    private function getTrainingInfoFromRow($row) {
        $trainingInfo = new TrainingInfo();
        $trainingInfo->setId($row['id']);
        $trainingInfo->setTitle($row['title']);
        $trainingInfo->setDescription($row['description']);

        $startDate = strtotime($row['startdate']);
        $endDate = strtotime($row['enddate']);
        $curDate = time();

        $trainingInfo->setStartDate($row['startdate']);
        $trainingInfo->setEndDate($row['enddate']);

        if($startDate <= $curDate && $curDate <= $endDate) {
            $trainingInfo->setStatus(Training::$ONGOING);
        } else if($curDate > $endDate) {
            $trainingInfo->setStatus(Training::$COMPLETED);
        } else if($curDate < $startDate) {
            $trainingInfo->setStatus(Training::$UPCOMING);
        }

        $trainingInfo->setCreationDateTime($row['creationdatetime']);
        $trainingInfo->setUpdateTime($row['lastupdatetime']);
        
        return $trainingInfo;
    }
    
    private function getTrainingsByQuery($query) {
        $trainingInfoArray = array();
        $this->connection=$this->ConnectDB();
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $trainingInfoArray;
        }
        
        $result = mysql_query($query, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $trainingInfoArray;
        }
        
        while( $row = mysql_fetch_array($result) ) {
            $trainingInfo = $this->getTrainingInfoFromRow($row);
            $trainingInfoArray[]=$trainingInfo;
        }

        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $trainingInfoArray;
    }
    
}
?>
