
<?php
require_once dirname(__DIR__, 2) . '/config/database.php';

try {
    // Retrieve recipes from the database
    $stmt = $pdo->query(
        "SELECT recipe_id, title, description, category,
                prep_time_mins, cook_time_mins, servings
         FROM recipes
         ORDER BY created_at DESC"
    );

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $recipes = [];
    $databaseError = true;
}

function escapeRecipe($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Recipes</title>

    <link rel="stylesheet" href="../../assets/css/recipes.css">
</head>

<body>

<main class="recipe-page">

    <header>
        <h1>Discover Recipes</h1>
        <p>Explore delicious recipes and find your next favourite meal.</p>
    </header>

    <section aria-labelledby="recipe-heading">

        <h2 id="recipe-heading">All Recipes</h2>

        <?php if (!empty($databaseError)): ?>

            <p role="alert">
                We couldn't load the recipes. Please try again later.
            </p>

        <?php elseif (empty($recipes)): ?>

            <p>No recipes are available yet.</p>

        <?php else: ?>

            <div class="recipe-grid">

                <?php foreach ($recipes as $recipe): ?>

                    <article class="recipe-card">

                        <h3>
                            <?= escapeRecipe($recipe['title']); ?>
                        </h3>

                        <p>
                            <?= escapeRecipe($recipe['description']); ?>
                        </p>

                        <p>
                            <strong>Category:</strong>
                            <?= escapeRecipe($recipe['category']); ?>
                        </p>

                        <p>
                            <strong>Preparation:</strong>
                            <?= escapeRecipe($recipe['prep_time_mins']); ?>
                            minutes
                        </p>

                        <p>
                            <strong>Cooking:</strong>
                            <?= escapeRecipe($recipe['cook_time_mins']); ?>
                            minutes
                        </p>

                        <p>
                            <strong>Total time:</strong>
                            <?= (int) $recipe['prep_time_mins']
                                + (int) $recipe['cook_time_mins']; ?>
                            minutes
                        </p>

                        <p>
                            <strong>Servings:</strong>
                            <?= escapeRecipe($recipe['servings']); ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>
</html>
