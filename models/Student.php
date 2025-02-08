<?php
require_once 'config/database.php';

class Student {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register($data) {
        $query = "INSERT INTO student (namee, phone, gender, dob, department, yearr, ktuid) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssss", 
            $data['namee'],
            $data['phone'],
            $data['gender'],
            $data['dob'],
            $data['department'],
            $data['yearr'],
            $data['ktuid']
        );

        return mysqli_stmt_execute($stmt);
    }
} 