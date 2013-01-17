<?php

class DBConnect {
    
    private $username;
    private $pwd;
    private $database;
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
    
    function CloseConnectionDB() {
        mysql_close($this->connection);
    }
    
}
?>
