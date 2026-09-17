<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

// Check authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $type = $_POST['type'] ?? 'quote';
    $content = trim($_POST['content'] ?? '');
    
    // Validate type
    if (!in_array($type, ['photo', 'quote'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid post type.']);
        exit;
    }

    // Handle Image Upload if type is photo
    $media_url = null;
    if ($type === 'photo') {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'Image upload failed.']);
            exit;
        }

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Sanitize and secure filename
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Path relative to this script is ../images/uploads/
            $uploadFileDir = '../images/uploads/';
            $dest_path = $uploadFileDir . $newFileName;
            
            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $media_url = 'images/uploads/' . $newFileName; // URL for frontend
            } else {
                echo json_encode(['success' => false, 'message' => 'There was an error moving the uploaded file. Ensure permissions are set.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions)]);
            exit;
        }
    } else {
        // If it's a quote, ensure content isn't empty
        if (empty($content)) {
            echo json_encode(['success' => false, 'message' => 'Quote content cannot be empty.']);
            exit;
        }
    }

    // Insert into database
    try {
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, type, media_url, content) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $type, $media_url, $content]);
        
        echo json_encode(['success' => true, 'message' => 'Post created successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error while creating post.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
