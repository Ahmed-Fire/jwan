<?php
/**
 * Database Configuration File - EXAMPLE
 * Copy this file to db_config.php and update with your credentials
 * Ensure proper file permissions (e.g., 600 or 640)
 */

return [
    'host' => 'localhost',
    'dbname' => 'jwan',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];
