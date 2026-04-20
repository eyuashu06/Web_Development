<?php
// ===========================================
// LOGOUT SCRIPT
// ===========================================

require_once 'config.php';

// Destroy all session data
$_SESSION = array();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destroy session
session_destroy();

// Redirect to login page
header("Location: login.html");
exit();
?>