<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../views/auth/login.php');
    exit;
}
require __DIR__ . '/../../config/database.php';
$name = trim($_POST['name'] ?? '');
if ($name === '') {
    header('Location: ../../views/account/index.php?error=invalid_name');
    exit;
}
$stmt = $pdo->prepare('UPDATE users SET name = ? WHERE user_id = ?');
$stmt->execute([$name, $_SESSION['user_id']]);
header('Location: ../../views/account/index.php');
exit;
