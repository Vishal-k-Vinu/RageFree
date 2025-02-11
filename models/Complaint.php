<?php
require_once 'config/database.php';

class Complaint {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($data) {
        try {
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
            return false;
        }
    }

    public function getAll() {
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
    }

    public function getById($id) {
        $query = "SELECT * FROM complaint WHERE complaintid = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $complaint = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $complaint;
    }

    public function getTotalComplaints() {
        $query = "SELECT COUNT(*) as total FROM complaint";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $row['total'];
    }
} 