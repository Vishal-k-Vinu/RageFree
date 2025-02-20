
<?php 
$title = 'Complaint Received';
require_once 'views/layouts/main.php';
?>

<?php ob_start(); ?>
<div class="container">
    <div class="success-wrapper">
        <h1>Complaint Received</h1>
        <div class="success-message">
            <i class='bx bx-check-circle'></i>
            <p>Your complaint has been successfully received and will be processed.</p>
            <p>Complaint ID: <strong><?php echo htmlspecialchars($_SESSION['last_complaint_id'] ?? ''); ?></strong></p>
        </div>
        <div class="action-buttons">
            <a href="/phplogin/logout" class="btn btn-primary">Go to Login</a>
            <a href="/complaint/create" class="btn btn-secondary">Submit Another Complaint</a>
        </div>
        <div class="note">
            <p>Please keep your complaint ID for future reference.</p>
        </div>
    </div>
</div>

<style>
.success-wrapper {
    text-align: center;
    padding: 40px 20px;
    max-width: 600px;
    margin: 0 auto;
}

.success-message {
    margin: 30px 0;
    padding: 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}

.success-message i {
    font-size: 48px;
    color: #4CAF50;
    margin-bottom: 20px;
}

.action-buttons {
    margin: 30px 0;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.btn {
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #4CAF50;
    color: white;
}

.btn-secondary {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.note {
    margin-top: 30px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
}
</style>

<?php 
$content = ob_get_clean();
require 'views/layouts/main.php';
?> 
