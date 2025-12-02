<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }
    
    // Get email
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    
    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'Valid email is required']);
        exit;
    }
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        // Generate reset token
        $token = generateResetToken();
        $expiry = date('Y-m-d H:i:s', time() + 3600); // 1 hour from now
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?");
        $stmt->execute([$token, $expiry, $email]);
        
        // Send reset email
        sendResetEmail($email, $token);
        
        echo json_encode(['success' => true, 'message' => 'Password reset instructions sent to your email']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email not found']);
    }
}
?>