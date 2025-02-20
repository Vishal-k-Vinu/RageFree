<?php
require_once 'config/database.php';

class Complaint {
    private $conn;
    private $database;

    public function __construct() {
        $this->database = new Database();
        $this->conn = $this->database->getConnection();
        
        if (!$this->conn) {
            error_log("Database connection failed in Complaint model");
            throw new Exception("Database connection failed");
        }
    }

    public function create($data) {
        try {
            error_log("Attempting to create complaint with data: " . print_r($data, true));
            
            $query = "INSERT INTO complaint (complaintid, stuname, incdate, placeofinc, descriptionn) 
                     VALUES (?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt === false) {
                error_log("Prepare failed: " . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "sssss", 
                $data['complaintid'],
                $data['stuname'],
                $data['incdate'],
                $data['placeofinc'],
                $data['descriptionn']
            );

            $success = mysqli_stmt_execute($stmt);
            
            if (!$success) {
                error_log("Execute failed: " . mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);
            return $success;

        } catch (Exception $e) {
            error_log("Error in Complaint::create: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM complaint";
            $result = mysqli_query($this->conn, $query);
            $complaints = [];

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $complaints[] = $row;
                }
                mysqli_free_result($result);
            }

            return $complaints;
        } catch (Exception $e) {
            error_log("Error in Complaint::getAll: " . $e->getMessage());
            return [];
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM complaint WHERE complaintid = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt === false) {
                error_log("Prepare failed in getById: " . mysqli_error($this->conn));
                return null;
            }

            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $complaint = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $complaint;
        } catch (Exception $e) {
            error_log("Error in Complaint::getById: " . $e->getMessage());
            return null;
        }
    }

    public function getTotalComplaints() {
        try {
            $query = "SELECT COUNT(*) as total FROM complaint";
            $result = mysqli_query($this->conn, $query);
            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            return $row['total'];
        } catch (Exception $e) {
            error_log("Error in Complaint::getTotalComplaints: " . $e->getMessage());
            return 0;
        }
    }

    // Remove destructor to prevent premature connection closing
    // Connection will be closed by Database class destructor
} 
