
<?php
class Encryption {
    private $key = "YourSecretKey123456";
    private $iv = '1234567890abcdef';

    public function encrypt($data) {
        $encrypted = openssl_encrypt(
            $data,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );
        return base64_encode($encrypted);
    }

    public function decrypt($data) {
        $decoded = base64_decode($data);
        return openssl_decrypt(
            $decoded,
            'AES-256-CBC',
            $this->key,
            OPENSSL_RAW_DATA,
            $this->iv
        );
    }
} 
