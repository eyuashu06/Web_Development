<?php
// ===========================================
// REGISTRATION PROCESSING
// ===========================================

require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Get form data
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$department = trim($_POST['department'] ?? '');
$gender = $_POST['gender'] ?? '';
$hobbies = isset($_POST['hobbies']) ? implode(', ', $_POST['hobbies']) : '';

// ===========================================
// VALIDATION
// ===========================================

if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($department) || empty($gender)) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields!']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address!']);
    exit();
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long!']);
    exit();
}

if ($password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match!']);
    exit();
}

// ===========================================
// DATABASE OPERATIONS
// ===========================================

$conn = getConnection();

// Check if email already exists
$check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already registered! Please use a different email.']);
    $check_stmt->close();
    $conn->close();
    exit();
}
$check_stmt->close();

// Hash password and insert user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$insert_stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, department, gender, hobbies) VALUES (?, ?, ?, ?, ?, ?, ?)");
$insert_stmt->bind_param("sssssss", $first_name, $last_name, $email, $hashed_password, $department, $gender, $hobbies);

if ($insert_stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Registration successful! Redirecting to login...']);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
}

$insert_stmt->close();
$conn->close();
?>