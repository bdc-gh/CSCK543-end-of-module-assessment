<?php
// Dynamically determine relative base path based on current directory depth
$base_path = '';
if (file_exists('config/database.php')) {
    $base_path = '';
} elseif (file_exists('../config/database.php')) {
    $base_path = '../';
} elseif (file_exists('../../config/database.php')) {
    $base_path = '../../';
} else {
    $base_path = '../../';
}
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require __DIR__ . '/../config/database.php';

$isLogin = isset($_SESSION['user_id']);
$name = '';

if ($isLogin) {
    $stmt = $pdo->prepare('SELECT name FROM users WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $user['name'] ?? '';
}

?>
<!DOCTYPE html>
<html lang="en-GB">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'RecipeApp · Culinary Journal'; ?></title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Pure Local Stylesheet -->
    <link rel="stylesheet" href="<?= $base_path; ?>assets/css/recipes.css">
    <link rel="stylesheet" href="<?= $base_path; ?>assets/css/account-menu.css">
</head>

<body>

    <header class="site-header">
        <div class="header-container">
            <a class="brand-logo" href="<?= $base_path; ?>index.php">
                <span class="brand-title">RecipeApp</span>
                <span class="brand-subtitle">Kitchen Journal</span>
            </a>
            <nav>
                <ul class="nav-links">
                    <li><a href="<?= $base_path; ?>views/recipes/index.php">Recipe Archive</a></li>
                    <li><a href="<?= $base_path; ?>index.php">Return Home</a></li>
                </ul>
            </nav>
            <div class="auth-actions">
                <?php if ($isLogin): ?>
                    <details class="account-menu">
                        <summary class="account-menu-trigger"><span class="account-menu-avatar material-symbols-outlined" aria-hidden="true">person</span><span class="account-menu-name"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></span><span class="account-menu-chevron" aria-hidden="true"></span></summary>
                        <div class="account-menu-panel">
                            <a class="account-menu-link" href="<?= $base_path; ?>views/account/index.php">My account</a>
                            <form action="<?= $base_path; ?>backend/auth/loginout.php" method="post">
                                <button type="submit" class="account-menu-logout">Log out</button>
                            </form>
                        </div>
                    </details>
                <?php else: ?>
                    <a class="btn-signin" href="<?= $base_path; ?>views/auth/login.php">Sign In</a>
                    <a class="btn-register" href="<?= $base_path; ?>views/auth/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
