<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <form action="../../backend/auth/register_handler.php" method="post">
            <label for="name">name:</label><input type="text" id="name" name="name" placeholder="Please enter your name">
            <label for="email">email:</label><input type="text" id="email" name="email" placeholder="Please enter your email">
            <label for="password">password:</label><input type="password" id="password" name="password" placeholder="Please enter your password">
            <label for="password_verify">verify password:</label><input type="password" id="password_verify" name="password_verify" placeholder="Please verify your password">
            <button>register</button>
        </form>
    </div>
</body>

</html>