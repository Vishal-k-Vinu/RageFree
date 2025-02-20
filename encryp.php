<?php
// AES-256 Encryption & Decryption in PHP

define('ENCRYPTION_KEY', 'your-secret-key-32-chars-long'); // Must be 32 bytes for AES-256

function encryptData($data, $key) {
    $iv = openssl_random_pseudo_bytes(16); // AES-256 requires a 16-byte IV
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($data, $key) {
    $data = base64_decode($data);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'] ?? '';
    $action = $_POST['action'] ?? '';
    
    if ($action === 'Encrypt') {
        $output = encryptData($message, ENCRYPTION_KEY);
    } elseif ($action === 'Decrypt') {
        $output = decryptData($message, ENCRYPTION_KEY);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>AES-256 Encryption in PHP</title>
</head>
<body>
    <h2>AES-256 Encryption & Decryption</h2>
    <form method="post">
        <label>Enter Message:</label>
        <input type="text" name="message" required>
        <br><br>
        <button type="submit" name="action" value="Encrypt">Encrypt</button>
        <button type="submit" name="action" value="Decrypt">Decrypt</button>
    </form>
    <?php if (!empty($output)): ?>
        <h3>Result:</h3>
        <p><?php echo htmlspecialchars($output); ?></p>
    <?php endif; ?>
</body>
</html>
