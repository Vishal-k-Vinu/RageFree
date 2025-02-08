<?php
require_once 'models/Complaint.php';

class AdminController {
    private $complaintModel;

    public function __construct() {
        $this->complaintModel = new Complaint();
    }

    public function dashboard() {
        // Check if admin is logged in
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] !== 'admin') {
            header('Location: login');
            exit();
        }

        $totalComplaints = $this->complaintModel->getTotalComplaints();
        $complaints = $this->complaintModel->getAll();
        
        include 'views/admin/dashboard.php';
    }
} 