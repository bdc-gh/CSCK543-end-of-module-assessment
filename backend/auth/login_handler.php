<?php
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email == '' || $password == '') {
    header('Location:../../views/auth/login.php?error=invalid_credentials');
    exit;
}
require __DIR__ . '/../../config/database.php';

session_start();

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Use the same error for an unknown email and an incorrect password.
if (!$user || !password_verify($password, $user['password_hash'])) {
    header('Location:../../views/auth/login.php?error=invalid_credentials');
    exit;
}
// Give the authenticated user a new session ID.
session_regenerate_id(true);
$_SESSION['user_id'] = $user['user_id'];

header('location:../../index.php');
exit;
