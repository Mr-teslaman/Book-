<?php
// Database configuration
$host = 'localhost';
$db = 'nyote_tech';
$user = 'root';
$pass = '';

// Create PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF token
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validate CSRF token
function validateCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Password strength validation
function isPasswordStrong($password) {
    // At least 8 characters, one number, and one symbol
    return strlen($password) >= 8 && preg_match('/[0-9]/', $password) && preg_match('/[^A-Za-z0-9]/', $password);
}

// Generate reset token
function generateResetToken() {
    return bin2hex(random_bytes(32));
}

// Send password reset email (pseudo-code)
function sendResetEmail($email, $token) {
    $resetLink = "https://tickify.co.ke/reset-password?token=$token";
    $subject = "TICKIFY TICKET - Password Reset Request";
    $message = "Click the following link to reset your password: $resetLink\n\nThis link will expire in 1 hour.";
    $headers = "From: no-reply@nyotech.com";
    
    // In a real application, use a proper email library
    mail($email, $subject, $message, $headers);
}
?>