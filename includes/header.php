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
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'RecipeApp · Culinary Journal'; ?></title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <!-- Pure Local Stylesheet -->
    <link rel="stylesheet" href="<?= $base_path; ?>assets/css/recipes.css">
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
                <a class="btn-signin" href="<?= $base_path; ?>views/auth/login.php">Sign In</a>
                <a class="btn-register" href="<?= $base_path; ?>views/auth/register.php">Register</a>
            </div>
        </div>
    </header>