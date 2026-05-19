<?php

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $dbport = DB_PORT;

    public $conn;

    public function __construct()
    {
        $this->connectDB();
    }

    private function connectDB()
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname,
            $this->dbport
        );

        if ($this->conn->connect_error)
        {
            die("Database Connection Failed : " .
                $this->conn->connect_error);
        }
    }
}

?>