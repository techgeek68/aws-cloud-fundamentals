<?php
// config.php - Database connection configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if DB credentials are in session
if (empty($_SESSION['db_host']) || empty($_SESSION['db_user']) || !array_key_exists('db_pass', $_SESSION)) {
    header('Location: login.php');
    exit;
}

$db_host = $_SESSION['db_host'];
$db_user = $_SESSION['db_user'];
$db_pass = $_SESSION['db_pass'];
$db_name = !empty($_SESSION['db_name']) ? $_SESSION['db_name'] : 'lab';

// Create connection
$conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    $_SESSION['db_error'] = $conn->connect_error;
    unset($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name']);
    header('Location: login.php');
    exit;
}

$conn->set_charset('utf8mb4');
?>
