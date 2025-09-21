<?php
define('DB_HOST', 'lab-db.cr0s8miyua9l.us-east-1.rds.amazonaws.com');            // Replace with your own
define('DB_USER', 'admin');                                                     // RDS master username (from your setup)
define('DB_PASS', 'lab-password');                                             // RDS master password
define('DB_NAME', 'lab');                                                     // Initial database name
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
