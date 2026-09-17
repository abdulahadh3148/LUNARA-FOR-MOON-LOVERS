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
    $bio = trim($_POST['bio'] ?? '');
    
    $update_query = "UPDATE users SET bio = :bio";
    $params = [':bio' => $bio, ':id' => $user_id];
    
    // Handle Avatar Upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/avatars/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_info = pathinfo($_FILES['avatar']['name']);
        $ext = strtolower($file_info['extension']);
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($ext, $allowed)) {
            $new_name = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
            $target = $upload_dir . $new_name;
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
                $avatar_url = 'uploads/avatars/' . $new_name;
                $update_query .= ", avatar_url = :avatar";
                $params[':avatar'] = $avatar_url;
            }
        }
    }
    
    $update_query .= " WHERE id = :id";
    
    try {
        $stmt = $pdo->prepare($update_query);
        $stmt->execute($params);
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
