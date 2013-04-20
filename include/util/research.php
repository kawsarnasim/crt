<?php

require_once(dirname(dirname(__FILE__)).'/data/researchinfo.php');
include "dbconnect.php";

class Research extends DBConnect{
    
    public static $ONGOING = 1;
    public static $COMPLETED = 2;
    public static $UPCOMING = 3;

    //-----Initialization -------
    function Research() {
        parent::DBConnect();
        $this->connection="";
    }
    
    function getAllResearches() {
        
        $researchInfoArray = $this->getResearchesByQuery("SELECT * FROM researches ORDER BY startdate DESC, enddate DESC, title ASC");
        
        return $researchInfoArray;        
    }
    
    function getOngoingResearches() {
        
        $researchInfoArray = $this->getResearchesByQuery("SELECT * FROM researches WHERE startdate <= CURDATE() and enddate >= CURDATE()");
        
        return $researchInfoArray;        
    }
    
    function getPastResearches() {
        
        $researchInfoArray = $this->getResearchesByQuery("SELECT * FROM researches WHERE enddate < CURDATE()");
        
        return $researchInfoArray;        
    }
    
    function getFutureResearches() {
        
        $researchInfoArray = $this->getResearchesByQuery("SELECT * FROM researches WHERE startdate > CURDATE()");
        
        return $researchInfoArray;        
    }
    
    function getResearchInfo($researchId) {
        
        $researchInfoArray = $this->getResearchesByQuery("SELECT * FROM researches WHERE id=$researchId");
        
        $researchInfo = (count($researchInfoArray)==0) ? NULL : $researchInfoArray[0];        
        
        return $researchInfo;        
    }
        
    /**
     * Create a new Research in the Database.
     * @return int the research id
     */
    function createResearch($title, $description, $startDate, $endDate) {
        $id_research = 0;
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_research;
        }
        
        $qry =  "INSERT INTO researches (title, description, startdate, enddate, creationdatetime, lastupdatetime)"
                ." VALUES ('$title', '$description','$startDate','$endDate', CURDATE(), CURDATE());";
        
        if(!mysql_query($qry, $this->connection)) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $id_research;
        }
        
        $id_research = mysql_insert_id($this->connection);
        
        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $id_research;
    }
    
    /**
     * Delete a specific notice from database
     */
    function deleteResearch($id_research) {
        $researchInfo = $this->getResearchInfo($id_research);
        if($researchInfo==NULL) {
            return "fail";
        }
                
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
                
        $qry =  "DELETE FROM researches WHERE id=$id_research";
        
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
     * Update a research in the database 
     */
    function updateResearch($id_research, $title, $startDate, $endDate, $desc) {
        
        $this->connection=$this->ConnectDB();
        
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return "fail";
        }
        $qry =  "UPDATE researches SET title='$title', description='$desc', startdate='$startDate', enddate= '$endDate', lastupdatetime=CURDATE() WHERE id=$id_research";
               
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
    
    private function getResearchInfoFromRow($row) {
        $researchInfo = new ResearchInfo();
        $researchInfo->setId($row['id']);
        $researchInfo->setTitle($row['title']);
        $researchInfo->setDescription($row['description']);

        $startDate = strtotime($row['startdate']);
        $endDate = strtotime($row['enddate']);
        $curDate = time();

        $researchInfo->setStartDate($row['startdate']);
        $researchInfo->setEndDate($row['enddate']);

        if($startDate <= $curDate && $curDate <= $endDate) {
            $researchInfo->setStatus(Research::$ONGOING);
        } else if($curDate > $endDate) {
            $researchInfo->setStatus(Research::$COMPLETED);
        } else if($curDate < $startDate) {
            $researchInfo->setStatus(Research::$UPCOMING);
        }

        $researchInfo->setCreationDateTime($row['creationdatetime']);
        $researchInfo->setUpdateTime($row['lastupdatetime']);
        
        return $researchInfo;
    }
    
    private function getResearchesByQuery($query) {
        $researchInfoArray = array();
        $this->connection=$this->ConnectDB();
        if($this->connection==NULL) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $researchInfoArray;
        }
        
        $result = mysql_query($query, $this->connection);

        if (!$result || mysql_num_rows($result) <= 0) {
            try {
                $this->CloseConnectionDB();
            } catch(Exception $exc) {}
            return $researchInfoArray;
        }
        
        while( $row = mysql_fetch_array($result) ) {
            $researchInfo = $this->getResearchInfoFromRow($row);
            $researchInfoArray[]=$researchInfo;
        }

        try {
            $this->CloseConnectionDB();
        } catch(Exception $exc) {}
        
        return $researchInfoArray;
    }
    
}
?>
