<?php

class Database {
    
    private $connection;

    //creates a new instance of database
    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            echo "Cannot connect to MySQL" . $this->connection->connect_error;
            exit();
        }
    }

    //retrieves database connection object
    public function getConnection() {
        return $this->connection;
    }

    //retrieves database errors
    public function getError() {
        return $this->connection->error;
    }

    //closes database connection
    public function close() {
        $this->connection->close();
    }

}