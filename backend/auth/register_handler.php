<?php
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$password_verify = $_POST['password_verify'] ?? '';
session_start();
// Keep these fields for one return to the form; never store passwords here.
$_SESSION['register_old'] = [
    'name' => $name,
    'email' => $email,
];
// Validate on the server even if the browser checks the form, because requests can bypass the registration page.
if (
    trim($name) === '' ||
    trim($email) === '' ||
    $password === '' ||
    $password !== $password_verify || filter_var($email, FILTER_VALIDATE_EMAIL) === false
) {
    header('Location: ../../views/auth/register.php?error=invalid_input');
    exit;
}
require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    header('location:../../views/auth/register.php?error=email_exists');
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);


$stmt = $pdo->prepare('INSERT INTO users(name,email,password_hash) VALUES (?,?,?)');
$stmt->execute([$name, $email, $hash]);
// Registration succeeded, so the saved form values are no longer needed.
unset($_SESSION['register_old']);
header('location:../../views/auth/login.php');
exit;
