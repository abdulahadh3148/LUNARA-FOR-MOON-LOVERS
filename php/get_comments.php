<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$post_id = $_GET['post_id'] ?? null;

if (!$post_id) {
    echo json_encode(['success' => false, 'message' => 'Post ID required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT c.id, c.comment_text, c.created_at, u.username, u.avatar_url 
        FROM comments c
        JOIN users u ON c.user_id = u.id
        WHERE c.post_id = ?
        ORDER BY c.created_at ASC
    ");
    $stmt->execute([$post_id]);
    $comments = $stmt->fetchAll();
    
    // Fallback avatars
    foreach ($comments as &$comment) {
        if (!$comment['avatar_url']) {
            $comment['avatar_url'] = 'https://i.pravatar.cc/150?u=' . md5($comment['username']);
        }
    }

    echo json_encode(['success' => true, 'comments' => $comments]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}
?>
