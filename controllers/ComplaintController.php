<?php
require_once 'models/Complaint.php';

class ComplaintController {
    private $complaintModel;

    public function __construct() {
        $this->complaintModel = new Complaint();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $this->showSuccess();
            } else {
                $error = "Failed to submit complaint";
                include 'views/student/complaint_form.php';
            }
        } else {
            include 'views/student/complaint_form.php';
        }
    }

    public function showSuccess() {
        if (!isset($_SESSION['last_complaint_id'])) {
            header('Location: /complaint/create');
            exit();
        }
        include 'views/student/complaint_success.php';
    }

    public function view() {
        if (isset($_POST['complaintid'])) {
            $complaint = $this->complaintModel->getById($_POST['complaintid']);
            include 'views/admin/view_complaint.php';
        } else {
            header('Location: admin/dashboard');
        }
    }
} 