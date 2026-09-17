<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'] ?? null;
    $comment_text = trim($_POST['comment_text'] ?? '');

    if (!$post_id || empty($comment_text)) {
        echo json_encode(['success' => false, 'message' => 'Post ID and comment text are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, post_id, comment_text) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $comment_text]);
        
        echo json_encode(['success' => true, 'message' => 'Comment added!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
