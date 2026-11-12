
<?php
// Start the session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
    if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
}

// Connect to the database
require_once __DIR__ . '/../../config/database.php';

// Require the user to be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/auth/login.php');
    exit;
}

// Retrieve this user's saved recipes
$stmt = $pdo->prepare(
    'SELECT recipes.*
     FROM recipes
     INNER JOIN saved_recipes
         ON recipes.recipe_id = saved_recipes.recipe_id
     WHERE saved_recipes.user_id = ?
     ORDER BY recipes.created_at DESC'
);

$stmt->execute([$_SESSION['user_id']]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'My Favourites · RecipeApp Kitchen';

include __DIR__ . '/../../includes/header.php';
?>

<main class="recipe-page">
    <div class="recipe-container">
        
        <h1>My Favourites</h1>
        <p>Your collection of saved recipes.</p>

        <?php if (empty($recipes)): ?>

            <p>You haven't saved any recipes yet.</p>
            <a href="index.php">Explore recipes</a>

        <?php else: ?>

            <div class="recipe-grid">

                <?php foreach ($recipes as $recipe): ?>

                    <div class="recipe-card">

                        <?php if (!empty($recipe['image_filename'])): ?>
                            <img
                                src="../../assets/images/recipes/<?= htmlspecialchars($recipe['image_filename'], ENT_QUOTES, 'UTF-8'); ?>"
                                alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>"
                                class="recipe-card-image"
                            >
                        <?php endif; ?>

                        <h2>
                            <?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <p>
                            <strong>Category:</strong>
                            <?= htmlspecialchars($recipe['category'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>

                        <p>
                            <strong>Total time:</strong>
                            <?= (int) $recipe['prep_time_mins'] + (int) $recipe['cook_time_mins']; ?>
                            minutes
                        </p>

                        <a href="detail.php?id=<?= (int) $recipe['recipe_id']; ?>">
                            View recipe
                        </a>

                        <form action="../../backend/favourites/favourites_handler.php" method="POST" class="favourite-form">
                            <input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>"
>
                            <input
                                type="hidden"
                                name="recipe_id"
                                value="<?= (int) $recipe['recipe_id']; ?>"
                            >

                            <button type="submit" class="favourite-button">
                                Remove favourite
                            </button>
                        </form>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
