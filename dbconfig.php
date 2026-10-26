<?php
/**
 * Database Configuration File
 * Location: PDO/dbconfig.php
 * 
 * Configures and establishes a PDO connection to the MySQL database.
 */

// Database connection parameters
define('DB_HOST', 'localhost');      // Server host (typically localhost or 127.0.0.1)
define('DB_PORT', '3306');           // Standard MySQL port
define('DB_NAME', 'grocery_db');     // Target database name containing Italian grocery tables
define('DB_USER', 'root');           // MySQL username
define('DB_PASS', '');               // MySQL password

// Formulate the Data Source Name (DSN) string with utf8mb4 encoding
$dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";

// Configure PDO attributes for security and error handling
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on SQL/connection errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch database records as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation to enforce native prepared statements
];

try {
    // Instantiate the PDO instance to establish connection
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Log exception and halt execution if connection fails
    die("Database Connection Error: " . $e->getMessage());
}
?>
