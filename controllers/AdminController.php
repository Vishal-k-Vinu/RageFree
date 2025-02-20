
<?php
require_once 'models/Complaint.php';

class AdminController {
    private $complaintModel;

    public function __construct() {
        $this->complaintModel = new Complaint();
    }

    public function dashboard() {
        // Remove session_start() since it's already started in index.php
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] !== 'admin') {
            header('Location: /phplogin/login');
            exit();
        }

        $totalComplaints = $this->complaintModel->getTotalComplaints();
        $complaints = $this->complaintModel->getAll();
        
        ob_start();
        include 'views/admin/dashboard.php';
        $content = ob_get_clean();
        include 'views/layouts/main.php';
    }
} 
