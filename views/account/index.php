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
    <title>My account | Recipe App</title>
    <link rel="stylesheet" href="../../assets/css/account.css">
</head>

<body class="account-page">
    <header class="account-header">
        <a class="account-brand" href="../../index.php">Recipe <span>App</span></a>
        <nav aria-label="Account navigation">
            <a href="../../index.php">Home</a>
            <span aria-current="page">My account</span>
        </nav>
    </header>

    <main class="account-main">
        <div class="account-heading">
            <p class="account-kicker">Your kitchen journal / Account</p>
            <h1>My account</h1>
            <p>A quiet place for your details and the recipes you want to return to.</p>
        </div>

        <div class="account-grid">
            <section class="account-panel" aria-labelledby="details-heading">
                <div class="panel-heading">
                    <div>
                        <p class="section-number">01 / Your details</p>
                        <h2 id="details-heading">Personal information</h2>
                    </div>
                    <button class="text-action" type="button" id="editButton">Edit name <span aria-hidden="true">↗</span></button>
                </div>
                <dl class="detail-list">
                    <div>
                        <dt>Name</dt>
                        <dd><?= htmlspecialchars($user['name'], ENT_QUOTES, 'utf-8') ?></dd>
                    </div>
                    <div>
                        <dt>Email address</dt>
                        <dd><?= htmlspecialchars($user['email'], ENT_QUOTES, 'utf-8') ?></dd>
                    </div>
                </dl>
            </section>

            <section class="account-panel favourites-panel" aria-labelledby="favourites-heading">
                <p class="section-number">02 / Recipe collection</p>
                <h2 id="favourites-heading">Saved recipes</h2>
                <div class="favourites-placeholder" aria-hidden="true">✳</div>
                <p>view all →</p>
            </section>
        </div>

        <div class="account-footer">
            <p>Good cooking begins with a little curiosity.</p>
            <form action="../../backend/auth/loginout.php" method="post">
                <button class="logout-button" type="submit">Log out <span aria-hidden="true">→</span></button>
            </form>
        </div>
    </main>

    <dialog class="edit-dialog" id="editDialog" aria-labelledby="editTitle">
        <div class="dialog-heading">
            <p class="section-number">Update your details</p>
            <h2 id="editTitle">Edit your name</h2>
            <p>This is the name shown on your account.</p>
        </div>
        <form action="../../backend/account/profile_handler.php" method="post">
            <label for="newName">Name</label>
            <input id="newName" name="name" type="text" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'utf-8') ?>" autocomplete="name" required>
            <div class="dialog-actions">
                <button class="cancel-button" type="button" id="cancelButton">Cancel</button>
                <button class="save-button" type="submit">Save changes</button>
            </div>
        </form>
    </dialog>
    <script src="../../assets/js/dialog_controller.js"></script>

</body>

</html>