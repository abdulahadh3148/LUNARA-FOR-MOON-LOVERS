<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Don't block unauthenticated users, just set user_id to 0
$user_id = $_SESSION['user_id'] ?? 0;

try {
    $stmt = $pdo->prepare("
        SELECT p.id, p.user_id, p.type, p.media_url, p.content, p.created_at, 
               u.username, u.avatar_url,
               (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count,
               (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comment_count,
               (SELECT COUNT(*) FROM likes WHERE post_id = p.id AND user_id = ?) as user_liked
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC
        LIMIT 50
    ");
    $stmt->execute([$user_id]);
    $posts = $stmt->fetchAll();
    
    // Fallback avatars if null
    foreach ($posts as &$post) {
        if (!$post['avatar_url']) {
            $post['avatar_url'] = 'https://i.pravatar.cc/150?u=' . md5($post['username']);
        }
    }
    
    echo json_encode(['success' => true, 'posts' => $posts]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch posts.']);
}
?>
