<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $follower_id = $_SESSION['user_id'];
    $following_id = $_POST['following_id'] ?? null;

    if (!$following_id || $follower_id == $following_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
        exit;
    }

    try {
        // Check if already following
        $stmt = $pdo->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$follower_id, $following_id]);
        $exists = $stmt->fetch();

        if ($exists) {
            // Unfollow
            $stmt = $pdo->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
            $stmt->execute([$follower_id, $following_id]);
            echo json_encode(['success' => true, 'action' => 'unfollowed']);
        } else {
            // Follow
            $stmt = $pdo->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
            $stmt->execute([$follower_id, $following_id]);
            echo json_encode(['success' => true, 'action' => 'followed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
