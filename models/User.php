<?php
require_once 'config/database.php';
require_once 'utils/Encryption.php';

class User {
    private $conn;
    private $encryption;
    private $database;

    public function __construct() {
        $this->database = new Database();
        $this->conn = $this->database->getConnection();
        $this->encryption = new Encryption();
    }

    public function authenticate($username, $password, $role) {
        $query = "SELECT * FROM datas WHERE roles = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $decrypted_username = $this->encryption->decrypt($user_data['uname']);
            $decrypted_password = $this->encryption->decrypt($user_data['pass']);

            if ($username === $decrypted_username && $password === $decrypted_password) {
                return $user_data;
            }
        }
        return false;
    }

    public function register($data) {
        try {
            $encrypted_username = $this->encryption->encrypt($data['username']);
            $encrypted_password = $this->encryption->encrypt($data['password']);
            
            $query = "INSERT INTO datas (fname, lname, uname, email, pass, roles) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->conn, $query);
            
            if ($stmt === false) {
                error_log("Prepare failed: " . mysqli_error($this->conn));
                return false;
            }

            mysqli_stmt_bind_param($stmt, "ssssss", 
                $data['firstname'],
                $data['lastname'],
                $encrypted_username,
                $data['email'],
                $encrypted_password,
                $data['role']
            );

            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;

        } catch (Exception $e) {
            error_log("Error in User::register: " . $e->getMessage());
            return false;
        }
    }

    // Add destructor to prevent premature connection closing
    public function __destruct() {
        // Connection will be closed by Database class destructor
    }
}
