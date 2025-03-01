<?php
require_once 'models/Complaint.php';

class ComplaintController {
    private $complaintModel;

    public function __construct() {
        $this->complaintModel = new Complaint();
    }

    public function create() {
        // Check if user is logged in and is a student
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] !== 'users') {
            header('Location: /phplogin/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate inputs
            if (empty($_POST['complaintid']) || empty($_POST['stuname']) || 
                empty($_POST['incdate']) || empty($_POST['placeofinc']) || 
                empty($_POST['descriptionn'])) {
                $error = "All fields are required";
                ob_start();
                include 'views/student/complaint_form.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
                return;
            }

            $complaintData = [
                'complaintid' => $_POST['complaintid'],
                'stuname' => $_POST['stuname'],
                'incdate' => $_POST['incdate'],
                'placeofinc' => $_POST['placeofinc'],
                'descriptionn' => $_POST['descriptionn']
            ];

            if ($this->complaintModel->create($complaintData)) {
                // Store the complaint ID in session for the success page
                $_SESSION['last_complaint_id'] = $complaintData['complaintid'];
                header('Location: /phplogin/complaint/success');
                exit();
            } else {
                $error = "Failed to submit complaint. Please try again.";
                ob_start();
                include 'views/student/complaint_form.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
            }
        } else {
            ob_start();
            include 'views/student/complaint_form.php';
            $content = ob_get_clean();
            include 'views/layouts/main.php';
        }
    }

    public function showSuccess() {
        if (!isset($_SESSION['last_complaint_id'])) {
            header('Location: /phplogin/complaint/create');
            exit();
        }
        ob_start();
        include 'views/student/complaint_success.php';
        $content = ob_get_clean();
        include 'views/layouts/main.php';
    }

    public function view() {
        if (isset($_POST['complaintid'])) {
            $complaint = $this->complaintModel->getById($_POST['complaintid']);
            ob_start();
            include 'views/admin/view_complaint.php';
            $content = ob_get_clean();
            include 'views/layouts/main.php';
        } else {
            header('Location: /phplogin/admin/dashboard');
            exit();
        }
    }
}
?>