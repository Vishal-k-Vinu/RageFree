<?php
require_once 'models/Student.php';

class StudentController {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    public function registration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentData = [
                'namee' => $_POST['namee'],
                'phone' => $_POST['phone'],
                'gender' => $_POST['gender'],
                'dob' => $_POST['dob'],
                'department' => $_POST['department'],
                'yearr' => $_POST['yearr'],
                'ktuid' => $_POST['ktuid']
            ];

            if ($this->studentModel->register($studentData)) {
                header('Location: complaint/create');
                exit();
            } else {
                $error = "Registration failed";
                include 'views/student/registration.php';
            }
        } else {
            include 'views/student/registration.php';
        }
    }
} 