<?php
class Database {
    private static $instance = null;
    private $host = "localhost";
    private $username = "root";
    private $password = "";  // default XAMPP password is empty
    private $database = "db1";
    private $conn;

    public function __construct() {
        try {
            // Use mysqli_report to set error reporting mode
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $this->conn = mysqli_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );

            // Set charset to ensure proper encoding
            mysqli_set_charset($this->conn, 'utf8mb4');
        } catch(Exception $e) {
            // Log the error with more details
            error_log("Database connection error: " . $e->getMessage());
            error_log("Error code: " . $e->getCode());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Rethrow the exception with a more user-friendly message
            throw new Exception("Unable to connect to database. Please try again later.");
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Add destructor to properly close connection
    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
