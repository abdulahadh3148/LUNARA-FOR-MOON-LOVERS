<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username_or_email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username/Email and password are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, password_hash, onboarding_completed FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username_or_email, $username_or_email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Password is correct, start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode([
                'success' => true, 
                'message' => 'Login successful!', 
                'onboarding_completed' => (int)$user['onboarding_completed']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed. Please ensure MySQL is running.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
