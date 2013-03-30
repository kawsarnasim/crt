<?php

class DBConnect {
    
    private $username;
    private $pwd;
    private $database;
    private $db_host;
    private $tablename;
    private $connection;

    function DBConnect() {
        $this->connection="";
    }

    function InitDB($host, $uname, $pwd, $database) {
        $this->db_host = $host;
        $this->username = $uname;
        $this->pwd = $pwd;
        $this->database = $database;
    }
    
    function ConnectDB() {
        $this->connection = mysql_connect($this->db_host, $this->username, $this->pwd);

        if (!$this->connection) {
            return NULL;
        }
        
        if (!mysql_select_db($this->database, $this->connection)) {
            return NULL;
        }
        
        return $this->connection;
    }
    
    function getDBHost() {
        return $this->db_host;
    }
    
    function getDBUserName() {
        return $this->username;
    }
    
    function getDBPassword() {
        return $this->pwd;
    }
    
    function getDBName() {
        return $this->database;
    }
    
    function CloseConnectionDB() {
        mysql_close($this->connection);
    }
    
}
?>
