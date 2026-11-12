<?php
session_start();
// Restore submitted values once after a failed registration.
$old = $_SESSION['register_old'] ?? [];
unset($_SESSION['register_old']);
$error = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Recipe App</title>
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>

<body class="auth-page auth-register">
    <main class="auth-layout">
        <div class="auth-intro">
            <a class="auth-brand" href="../../index.php" aria-label="Recipe App home">Recipe<span>App</span></a>
            <p class="auth-eyebrow">Good food starts here</p>
            <h1>Make room for flavour.</h1>
            <p>Create an account and start building your own collection of recipes worth sharing.</p>
            <div class="auth-decoration" aria-hidden="true">✦ &nbsp; fresh ideas for every table &nbsp; ✦</div>
        </div>
        <section class="auth-card" aria-labelledby="register-heading">
            <p class="auth-card-kicker">Join the table</p>
            <h2 id="register-heading">Create an account</h2>
            <p class="auth-card-subtitle">A few details and you're ready to explore.</p>
            <?php if ($error === 'invalid_input'): ?>
                <div class="auth-feedback" role="alert" aria-live="polite">Please check your details and try again.</div>
            <?php endif; ?>
            <form action="../../backend/auth/register_handler.php" method="post">
                <div class="auth-field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your name" autocomplete="name" required value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'utf-8') ?>">
                </div>
                <div class="auth-field">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" autocomplete="email" required value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'utf-8') ?>">
                </div>
                <div class="auth-field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" required>
                </div>
                <div class="auth-field">
                    <label for="password_verify">Confirm password</label>
                    <input type="password" id="password_verify" name="password_verify" placeholder="Enter your password again" autocomplete="new-password" required>
                </div>
                <button class="auth-submit" type="submit">Register <span aria-hidden="true">→</span></button>
            </form>
            <p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p>
        </section>
    </main>
    <!-- Show a dialog when the email is already registered. -->
    <?php if ($error === 'email_exists'): ?>
        <dialog id="emailErrorDialog" aria-labelledby="emailErrorTitle" aria-describedby="emailErrorDescription">
            <div class="auth-dialog-content">
                <h2 id="emailErrorTitle">Email already registered</h2>
                <p id="emailErrorDescription">This email address is already registered.</p>
                <div class="auth-dialog-actions">
                    <a class="auth-dialog-primary" href="login.php">Log in <span aria-hidden="true">→</span></a>
                    <form method="dialog">
                        <button class="auth-dialog-secondary" type="submit">Use another email</button>
                    </form>
                </div>
            </div>
        </dialog>
        <script>
            document.querySelector('#emailErrorDialog').showModal();
        </script>
    <?php endif; ?>
    <!-- Check that both passwords match before submitting the form. -->
    <script>
        const password = document.querySelector('#password');
        const confirmPassword = document.querySelector('#password_verify');

        function checkPasswords() {
            const matches = password.value === confirmPassword.value;
            confirmPassword.setCustomValidity(
                matches ? '' : 'Passwords do not match.'
            );
        }

        password.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);
    </script>
</body>

</html>
