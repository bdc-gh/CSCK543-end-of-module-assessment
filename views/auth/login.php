<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recipe app</title>
</head>

<body>
    <div class="app-container">
        <section class="login-content">
            <form action="../../backend/auth/login_handler.php" method="post">
                <label for="email">email:</label><input type="text" id="email" name="email" placeholder="Please enter your email">
                <label for="password">password:</label><input type="password" id="password" name="password" placeholder="Please enter your password">
                <button>login in</button>
                <button>go register</button>
            </form>
        </section>
    </div>
</body>
<footer>recipe app</footer>

</html>