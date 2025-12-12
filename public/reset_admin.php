<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        die("Connection failed");
    }

    $password = 'admin123';
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if user exists first
    $check = $conn->query("SELECT id FROM users WHERE name = 'Admin'");
    if ($check->rowCount() == 0) {
        // Create if missing
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES ('Admin', 'admin@parsifalyoga.it', ?, 'admin')");
        $stmt->execute([$hash]);
        echo "User 'Admin' created with password '$password'.<br>";
    } else {
        // Update if exists
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE name = 'Admin'");
        $stmt->execute([$hash]);
        echo "User 'Admin' password updated to '$password'.<br>";
    }

    echo "Hash: " . $hash . "<br>";
    echo "DONE. Please delete this file.";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
