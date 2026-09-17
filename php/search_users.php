<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

$query = trim($_GET['q'] ?? '');

if (empty($query)) {
    echo json_encode(['success' => true, 'users' => []]);
    exit;
}

try {
    $current_user_id = $_SESSION['user_id'] ?? 0;
    
    // Search for users whose username matches the query (case insensitive via PDO/MySQL)
    // and include whether the current user is following them.
    $stmt = $pdo->prepare("
        SELECT id, username, avatar_url, bio,
               (SELECT COUNT(*) FROM follows WHERE follower_id = ? AND following_id = users.id) as is_following
        FROM users 
        WHERE username LIKE ? 
        LIMIT 20
    ");
    $stmt->execute([$current_user_id, '%' . $query . '%']);
    $users = $stmt->fetchAll();
    
    // Set fallback avatars
    foreach ($users as &$user) {
        if (!$user['avatar_url']) {
            $user['avatar_url'] = 'https://i.pravatar.cc/150?u=' . md5($user['username']);
        }
    }
    
    echo json_encode(['success' => true, 'users' => $users]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
