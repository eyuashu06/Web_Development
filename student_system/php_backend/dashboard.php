<?php
// ===========================================
// STUDENT DASHBOARD (PROTECTED PAGE)
// ===========================================

require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Get full user details from database
$conn = getConnection();
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h2>🎓 Student Management System</h2>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="welcome-card">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
            <p>You are successfully logged into your student dashboard.</p>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>👤 Personal Information</h3>
                <div class="info-item">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user_data['email']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Gender:</div>
                    <div class="info-value"><?php echo ucfirst(htmlspecialchars($user_data['gender'])); ?></div>
                </div>
            </div>

            <div class="info-card">
                <h3>📚 Academic Information</h3>
                <div class="info-item">
                    <div class="info-label">Department:</div>
                    <div class="info-value"><?php echo htmlspecialchars($user_data['department']); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Student ID:</div>
                    <div class="info-value">#<?php echo str_pad($user_data['id'], 6, '0', STR_PAD_LEFT); ?></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Registered:</div>
                    <div class="info-value"><?php echo date('F j, Y', strtotime($user_data['created_at'])); ?></div>
                </div>
            </div>

            <div class="info-card">
                <h3>⭐ Interests & Hobbies</h3>
                <div class="info-item">
                    <div class="info-label">Hobbies:</div>
                    <div class="info-value">
                        <?php if ($user_data['hobbies']): ?>
                            <div class="hobbies-list">
                                <?php 
                                $hobbies = explode(', ', $user_data['hobbies']);
                                foreach ($hobbies as $hobby): ?>
                                    <span class="hobby-tag"><?php echo htmlspecialchars($hobby); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <span style="color: #999;">No hobbies listed</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>