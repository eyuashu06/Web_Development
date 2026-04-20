<?php
// ===========================================
// DATABASE CONFIGURATION
// ===========================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Empty for XAMPP
define('DB_NAME', 'student_system');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===========================================
// DATABASE CONNECTION FUNCTION
// ===========================================

function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
    }
    
    return $conn;
}

// ===========================================
// HELPER FUNCTIONS
// ===========================================

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: login.html");
        exit();
    }
}

function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header("Location: dashboard.php");
        exit();
    }
}
?>