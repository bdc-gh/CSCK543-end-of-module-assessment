<?php
$error = $_GET['error'] ?? '';
$base_path = '../../'; // Root directory
$page_title = "Sign In · RecipeApp";
$page_stylesheet = "assets/css/auth.css";
$body_class = "auth-page auth-login";
// The shared header renders the page head and navigation.
include __DIR__ . '/../../includes/header.php';
?>


    <main class="auth-layout">
        <div class="auth-intro">
            <p class="auth-eyebrow">Good food starts here</p>
            <h1>Welcome back.</h1>
            <p>Log in to return to your favourite recipes and find something delicious to make next.</p>
            <div class="auth-decoration" aria-hidden="true">✦ &nbsp; fresh ideas for every table &nbsp; ✦</div>
        </div>
        <section class="auth-card" aria-labelledby="login-heading">
            <p class="auth-card-kicker">Your recipe collection</p>
            <h2 id="login-heading">Log in</h2>
            <p class="auth-card-subtitle">Enter your details to continue.</p>
            <?php if ($error === 'invalid_credentials'): ?>
                <div class="auth-feedback" role="alert" aria-live="polite">
                    Invalid email or password.
                </div>
            <?php endif; ?>
            <form action="../../backend/auth/login_handler.php" method="post">
                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" autocomplete="email" required>
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                </div>
                <button class="auth-submit" type="submit">Log in <span aria-hidden="true">→</span></button>
            </form>
            <p class="auth-switch">New to Recipe App? <a href="register.php">Create an account</a></p>
        </section>
    </main>
</body>

</html>
