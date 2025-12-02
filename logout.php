<?php
require_once 'config.php';

// Destroy session
session_destroy();

// Clear remember me cookie
setcookie('remember_token', '', time() - 3600, '/');

// Redirect to login page
header('Location: login.php');
exit;
?>