<?php

class Database {
    
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);
        if ($this->connection->connect_error) {
            echo "Cannot connect to MySQL" . $this->connection->connect_error;
            exit();
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getError() {
        return $this->connection->error;
    }

    public function close() {
        $this->connection->close();
    }

}