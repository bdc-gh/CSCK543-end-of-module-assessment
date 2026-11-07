<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password_verify = $_POST['password_verify'] ?? '';

if ($name == '') {
    echo 'Name should not be null.';
    exit;
}
if ($email == '') {
    echo 'Email should not be null.';
    exit;
}
if ($password == '') {
    echo 'Password should not be null.';
    exit;
}
if ($password !== $password_verify) {
    echo 'Passwords do not match.';
    exit;
}
require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo 'this email has been registered.';
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);


$stmt = $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES (?,?,?)');
$stmt->execute([$name, $email, $hash]);

header('location:/CSCK543-end-of-module-assessment/views/auth/login.php');
exit;
