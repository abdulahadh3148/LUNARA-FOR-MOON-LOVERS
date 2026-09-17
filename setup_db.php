<?php
require_once 'php/db.php';

try {
    $pdo->exec("ALTER TABLE users ADD COLUMN bio TEXT DEFAULT NULL;");
    echo "Added bio column.\n";
} catch (PDOException $e) {
    echo "Bio column might already exist or error: " . $e->getMessage() . "\n";
}

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS follows (
            id INT AUTO_INCREMENT PRIMARY KEY,
            follower_id INT NOT NULL,
            following_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE,
            UNIQUE KEY unique_follow (follower_id, following_id)
        );
    ");
    echo "Follows table created.\n";
} catch (PDOException $e) {
    echo "Error creating follows table: " . $e->getMessage() . "\n";
}
?>
