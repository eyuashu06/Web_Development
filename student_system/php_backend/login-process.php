<?php
// ===========================================
// LOGIN PROCESSING
// ===========================================

require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please enter both email and password!']);
    exit();
}

$conn = getConnection();

// Get user by email
$stmt = $conn->prepare("SELECT id, first_name, last_name, email, password, department FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_department'] = $user['department'];
        
        echo json_encode(['success' => true, 'message' => 'Login successful! Redirecting to dashboard...']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password!']);
}

$stmt->close();
$conn->close();
?>