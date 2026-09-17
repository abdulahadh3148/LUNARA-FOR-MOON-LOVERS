<?php
$host = 'localhost';
$dbname = 'lunara_db';
$username = 'root'; // default XAMPP username
$password = ''; // default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // TEMPORARY: Auto-update schema for Phase 6 & 7
    try { $pdo->exec("ALTER TABLE users ADD COLUMN bio TEXT DEFAULT NULL;"); } catch (PDOException $e) {}
    try { $pdo->exec("ALTER TABLE users ADD COLUMN onboarding_completed TINYINT(1) DEFAULT 0;"); } catch (PDOException $e) {}
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
    } catch (PDOException $e) {}

} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
