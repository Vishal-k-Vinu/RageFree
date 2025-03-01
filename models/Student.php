<?php
require_once 'config/database.php';

class Student {
    private $conn;
    private $database;

    public function __construct() {
        $this->database = new Database();
        $this->conn = $this->database->getConnection();
        
        if (!$this->conn) {
            error_log("Database connection failed");
            throw new Exception("Database connection failed");
        }
    }

    public function register($data) {
        try {
            // Check if table exists
            $result = mysqli_query($this->conn, "SHOW TABLES LIKE 'student'");
            if (!$result || mysqli_num_rows($result) == 0) {
                error_log("Student table does not exist!");
                return false;
            }

            // Check table structure
            $result = mysqli_query($this->conn, "DESCRIBE student");
            if ($result) {
                $columns = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $columns[] = $row['Field'];
                }
            }

            $query = "INSERT INTO student (namee, phone, gender, dob, department, yearr, ktuid) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt === false) {
                error_log("Prepare failed: " . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "sssssss", 
                $data['name'],
                $data['phone'],
                $data['gender'],
                $data['dob'],
                $data['department'],
                $data['year'],
                $data['ktuid']
            );

            $success = mysqli_stmt_execute($stmt);
            
            if (!$success) {
                error_log("Execute failed: " . mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);
            return $success;

        } catch (Exception $e) {
            error_log("Error in Student::register: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function isKtuIdExists($ktuid) {
        try {
            $query = "SELECT COUNT(*) as count FROM student WHERE ktuid = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt === false) {
                error_log("Prepare failed in isKtuIdExists: " . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "s", $ktuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $row['count'] > 0;
        } catch (Exception $e) {
            error_log("Error in isKtuIdExists: " . $e->getMessage());
            return false;
        }
    }

    
}
?>