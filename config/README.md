# Configuration Directory

This directory contains configuration files for the JWAN Furniture application.

## Required Files

### db_config.php
Database configuration file (not included in repository for security).

**Create this file with the following structure:**

```php
<?php
/**
 * Database Configuration File
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
```

## Setup Instructions

1. Copy the structure above to create `db_config.php` in this directory
2. Update the database credentials:
   - `host`: Your database server hostname
   - `dbname`: Your database name
   - `username`: Your database username
   - `password`: Your database password
3. Set secure file permissions: `chmod 600 db_config.php`

## Security Notes

- The `db_config.php` file is excluded from version control via `.gitignore`
- Never commit database credentials to the repository
- Use strong passwords for database access
- For production, consider using environment variables
