<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }
    
    // Get input
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($token) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Token and password are required']);
        exit;
    }
    
    if (!isPasswordStrong($password)) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters with a number and symbol']);
        exit;
    }
    
    // Check if token is valid and not expired
    $stmt = $pdo->prepare("SELECT id, reset_expiry FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user && strtotime($user['reset_expiry']) > time()) {
        // Token is valid, update password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
        $stmt->execute([$passwordHash, $user['id']]);
        
        echo json_encode(['success' => true, 'message' => 'Password reset successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired reset token']);
    }
}
?>