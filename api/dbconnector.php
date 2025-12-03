<?php
/**
 * Database Connector
 * Loads credentials from secure configuration file
 */

// Load database configuration from config directory
$config_path = dirname(__DIR__) . '/config/db_config.php';

if (!file_exists($config_path)) {
    die("Configuration file not found. Please ensure db_config.php exists in the config directory.");
}

$config = require $config_path;

try {
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $con = new PDO($dsn, $config['username'], $config['password'], $config['options']);
} catch (PDOException $e) {
    // Log error securely (don't expose details to users in production)
    error_log("Database connection failed: " . $e->getMessage());
    die("Connection failed. Please contact the system administrator.");
}
?>