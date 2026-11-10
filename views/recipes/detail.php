<?php
/**
 * RecipeApp Kitchen Journal - Single Recipe Detail View
 * Located at: views/recipes/detail.php
 */

require_once __DIR__ . '/../../config/database.php';

$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$recipe = null;
$error_notice = '';

if ($recipe_id > 0) {
    try {
        $statement = $pdo->prepare("SELECT * FROM recipes WHERE recipe_id = :id LIMIT 1");
        $statement->execute(['id' => $recipe_id]);
        $recipe = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$recipe) {
            $error_notice = "We couldn't find a recipe matching reference number #" . $recipe_id . " in our ledger.";
        }
    } catch (PDOException $exception) {
        $error_notice = "A database error occurred while retrieving this recipe.";
    }
} else {
    $error_notice = "No valid recipe identifier was provided in the address.";
}

$page_title = $recipe ? htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') . " · RecipeApp Kitchen" : "Recipe Not Found";
include __DIR__ . '/../../includes/header.php';
?>

<main class="recipe-page">
    <div class="recipe-container">
        
        <?php if (!empty($error_notice)): ?>
            <div class="recipe-detail-card" style="text-align: center; padding: 3rem;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: var(--outline); margin-bottom: 1rem;">error_outline</span>
                <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Recipe Unavailable</h1>
                <p style="color: var(--secondary); margin-bottom: 1.5rem;"><?= htmlspecialchars($error_notice, ENT_QUOTES, 'UTF-8'); ?></p>
                <a href="index.php" style="display: inline-block; background: var(--primary); color: #ffffff; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 6px; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.1em;">Return to Archive</a>
            </div>
        <?php elseif ($recipe): ?>
            <div style="margin-bottom: 1.5rem;">
                <a href="index.php" style="text-decoration: none; color: var(--secondary); font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.1em; display: inline-flex; align-items: center; gap: 0.375rem;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                    <span>Back to Archive</span>
                </a>
            </div>

            <article class="recipe-detail-card">
                <div class="recipe-detail-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="background: var(--surface-low); padding: 0.25rem 0.75rem; border-radius: 4px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600;">
                            <?= htmlspecialchars($recipe['category'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--outline);">
                            Ref. #<?= str_pad($recipe['recipe_id'], 3, '0', STR_PAD_LEFT); ?>
                        </span>
                    </div>
                    
                    <h1 class="recipe-detail-title"><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                    <p style="font-size: 1.125rem; color: var(--secondary); line-height: 1.6; margin-top: 0.5rem;">
                        <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>

                <div class="stats-grid">
                    <div class="stat-box">
                        <span class="label">Prep Time</span>
                        <span class="value"><?= (int)$recipe['prep_time_mins']; ?> mins</span>
                    </div>
                    <div class="stat-box">
                        <span class="label">Cook Time</span>
                        <span class="value"><?= (int)$recipe['cook_time_mins']; ?> mins</span>
                    </div>
                    <div class="stat-box">
                        <span class="label">Portions</span>
                        <span class="value"><?= (int)$recipe['servings']; ?> serves</span>
                    </div>
                </div>

                <div class="content-block">
                    <h2>
                        <span class="material-symbols-outlined" style="color: var(--secondary);">checklist</span>
                        <span>Pantry Ingredients</span>
                    </h2>
                    <div class="content-box">
                        <?= htmlspecialchars($recipe['ingredients'] ?? 'Ingredients list not provided for this entry.', ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>

                <div class="content-block">
                    <h2>
                        <span class="material-symbols-outlined" style="color: var(--secondary);">soup_kitchen</span>
                        <span>Preparation Method</span>
                    </h2>
                    <div class="content-box">
                        <?= htmlspecialchars($recipe['steps'] ?? 'Preparation steps not provided for this entry.', ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                </div>
            </article>
        <?php endif; ?>

    </div>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>