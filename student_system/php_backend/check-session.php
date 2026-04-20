<?php
// ===========================================
// CHECK SESSION STATUS (FOR AJAX)
// ===========================================

require_once 'config.php';

header('Content-Type: application/json');

if (isLoggedIn()) {
    echo json_encode([
        'loggedIn' => true,
        'user' => [
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'department' => $_SESSION['user_department']
        ]
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>