<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";  // default XAMPP password is empty
    private $database = "db1";
    private $conn;

    public function getConnection() {
        try {
            $this->conn = mysqli_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );

            if (!$this->conn) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }

            return $this->conn;
        } catch(Exception $e) {
            error_log("Connection error: " . $e->getMessage());
            throw $e;
        }
    }
}