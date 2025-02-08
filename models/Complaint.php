<?php
require_once 'config/database.php';

class Complaint {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create($data) {
        $query = "INSERT INTO complaint (complaintid, stuname, incdate, placeofinc, descriptionn) 
                 VALUES (?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", 
            $data['complaintid'],
            $data['stuname'],
            $data['incdate'],
            $data['placeofinc'],
            $data['descriptionn']
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getAll() {
        $query = "SELECT * FROM complaint";
        $result = mysqli_query($this->conn, $query);
        $complaints = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $complaints[] = $row;
            }
        }

        return $complaints;
    }

    public function getById($id) {
        $query = "SELECT * FROM complaint WHERE complaintid = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        return mysqli_fetch_assoc($result);
    }

    public function getTotalComplaints() {
        $query = "SELECT COUNT(*) as total_complaints FROM complaint";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total_complaints'];
    }
} 