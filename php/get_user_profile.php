<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_GET['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    exit;
}

try {
    // Get user info and stats
    $current_user = $_SESSION['user_id'] ?? 0;
    
    $stmt = $pdo->prepare("
        SELECT id, username, avatar_url, bio,
               (SELECT COUNT(*) FROM follows WHERE following_id = users.id) as followers,
               (SELECT COUNT(*) FROM follows WHERE follower_id = users.id) as following,
               (SELECT COUNT(*) FROM follows WHERE follower_id = ? AND following_id = users.id) as is_following
        FROM users 
        WHERE id = ?
    ");
    $stmt->execute([$current_user, $user_id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit;
    }
    
    if (!$user['avatar_url']) {
        $user['avatar_url'] = 'https://i.pravatar.cc/150?u=' . md5($user['username']);
    }

    // Get user's posts
    $stmt = $pdo->prepare("
        SELECT id, type, media_url, content, created_at,
               (SELECT COUNT(*) FROM likes WHERE post_id = posts.id) as like_count,
               (SELECT COUNT(*) FROM comments WHERE post_id = posts.id) as comment_count
        FROM posts
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $stmt->execute([$user_id]);
    $posts = $stmt->fetchAll();

    echo json_encode([
        'success' => true, 
        'user' => $user,
        'posts' => $posts
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
