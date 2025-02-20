<?php
require_once 'models/Student.php';

class StudentController {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

    public function registration() {
        // Check if user is logged in and is a student
        if (!isset($_SESSION['user']) || $_SESSION['user']['roles'] !== 'users') {
            header('Location: /phplogin/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debug log
            error_log("POST data received: " . print_r($_POST, true));

            // Validate input
            $errors = [];
            if (empty($_POST['namee'])) $errors[] = "Name is required";
            if (empty($_POST['phone']) || !preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
                $errors[] = "Valid phone number is required (10 digits)";
            }
            if (empty($_POST['gender'])) $errors[] = "Gender is required";
            if (empty($_POST['dob'])) $errors[] = "Date of birth is required";
            if (empty($_POST['department'])) $errors[] = "Department is required";
            if (empty($_POST['yearr'])) $errors[] = "Year is required";
            if (empty($_POST['ktuid'])) $errors[] = "KTU ID is required";

            if (!empty($errors)) {
                $error = implode("<br>", $errors);
                error_log("Validation errors: " . $error);
                ob_start();
                include 'views/student/registration.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
                return;
            }

            // Update the data array to match form field names
            $studentData = [
                'name' => $_POST['namee'],
                'phone' => $_POST['phone'],
                'gender' => $_POST['gender'],
                'dob' => $_POST['dob'],
                'department' => $_POST['department'],
                'year' => $_POST['yearr'],
                'ktuid' => $_POST['ktuid']
            ];

            // Debug log
            error_log("Attempting to register with data: " . print_r($studentData, true));

            if ($this->studentModel->register($studentData)) {
                error_log("Registration successful");
                // Immediately redirect to complaint creation page
                header('Location: /phplogin/complaint/create');
                exit();
            } else {
                error_log("Registration failed");
                $error = "Registration failed. Please try again.";
                ob_start();
                include 'views/student/registration.php';
                $content = ob_get_clean();
                include 'views/layouts/main.php';
            }
        } else {
            ob_start();
            include 'views/student/registration.php';
            $content = ob_get_clean();
            include 'views/layouts/main.php';
        }
    }
} 
