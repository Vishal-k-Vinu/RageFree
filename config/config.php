<?php
// Application configuration
return [
    'app' => [
        'name' => 'RageFree',
        'debug' => true,
        'base_url' => 'http://localhost/phplogin',
    ],

    'database' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'db1'
    ],
    'encryption' => [
        'key' => 'YourSecretKey123456',
        'iv' => '1234567890abcdef'
    ]
]; 