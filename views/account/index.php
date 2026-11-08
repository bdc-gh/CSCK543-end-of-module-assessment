<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:/CSCK543-end-of-module-assessment/views/auth/login.php');
    exit;
}

require __DIR__ . '/../../config/database.php';

$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <h1>My account</h1>
        <section class="account-detail">
            <div>name:<?= htmlspecialchars($user['name'], ENT_QUOTES, 'utf-8') ?> <button id="editButton">edit</button></div>
            <div>email:<?= htmlspecialchars($user['email'], ENT_QUOTES, 'utf-8') ?></div>
            <div>my favourites <span>10 saved recipes</span><span>view all →</span></div>
        </section>
        <form action="../../backend/auth/loginout.php" method="post">
            <button type="submit">Log out</button>
        </form>
        <dialog id="editDialog" aria-labelledby="editTitle">
            <h2 id="editTitle">Edit your name</h2>

            <form action="../../backend/account/profile_handler.php" method="post">
                <label for="newName">Name</label>
                <input id="newName" name="name" type="text" required>
                <button type="button" id="cancelButton">Cancel</button>
                <button type="submit">Save</button>
            </form>
        </dialog>
    </main>
    <script src="../../assets/js/dialog_controller.js"></script>

</body>

</html>