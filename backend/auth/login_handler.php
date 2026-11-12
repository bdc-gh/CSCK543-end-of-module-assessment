<?php
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email == '' || $password == '') {
    echo 'email or password should not be null';
    exit;
}
require __DIR__ . '/../../config/database.php';

session_start();

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo 'invalid email or password';
    exit;
}
if (!password_verify($password, $user['password_hash'])) {
    echo 'invalid email or password';
    exit;
}


$_SESSION['user_id'] = $user['user_id'];

header('location:../../index.php');
exit;
