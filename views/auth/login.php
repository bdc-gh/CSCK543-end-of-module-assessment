<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in | Recipe App</title>
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>
<body class="auth-page auth-login">
    <main class="auth-layout">
        <div class="auth-intro">
            <a class="auth-brand" href="../../index.php" aria-label="Recipe App home">Recipe<span>App</span></a>
            <p class="auth-eyebrow">Good food starts here</p>
            <h1>Welcome back.</h1>
            <p>Log in to return to your favourite recipes and find something delicious to make next.</p>
            <div class="auth-decoration" aria-hidden="true">✦ &nbsp; fresh ideas for every table &nbsp; ✦</div>
        </div>
        <section class="auth-card" aria-labelledby="login-heading">
            <p class="auth-card-kicker">Your recipe collection</p>
            <h2 id="login-heading">Log in</h2>
            <p class="auth-card-subtitle">Enter your details to continue.</p>
            <div class="auth-feedback" role="alert" aria-live="polite"></div>
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
