<?php
// dbinit.php

// Database credentials
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = "saichinnu123@"; // Your database password (ensure this is stored securely)
$dbname = "sai_praneeth"; // Your database name

// Enable MySQLi error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Set the charset to avoid charset issues
    $conn->set_charset("utf8mb4");
    
} catch (mysqli_sql_exception $e) {
    // Catch any connection error and display a more user-friendly message
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
