<?php
/**
 * Database Connector
 * Loads credentials from secure configuration file outside web root
 */

// Load database configuration from secure location
$config_path = dirname(__DIR__, 2) . '/jwan_config/db_config.php';

if (!file_exists($config_path)) {
    die("Configuration file not found. Please ensure db_config.php exists outside the web root.");
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