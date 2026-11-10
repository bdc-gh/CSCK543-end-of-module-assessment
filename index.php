<?php
/**
 * RecipeApp Culinary Journal - Home / Landing Page
 * Connects to MySQL via PDO, fetches all recipes, and renders 
 * the dynamic accessible HTML5 layout using modular header/footer.
 */

// 1. Connect to the MySQL database
require_once __DIR__ . '/config/database.php';

// 2. Fetch recipes securely using PDO
$recipes = [];
$error_message = '';

try {
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "We couldn't quite reach the pantry at the moment. Please pop back shortly.";
}

// 3. Set dynamic page title & include the pure CSS modular header
$page_title = "RecipeApp · Recipes";
include __DIR__ . '/includes/header.php';
?>

<!-- Seasonal Ribbon -->
<div class="kitchen-ribbon">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <span style="width: 6px; height: 6px; border-radius: 50%; background-color: var(--secondary);"></span>
        <span style="text-transform: uppercase; letter-spacing: 0.15em; font-size: 0.75rem;">Kitchen Dispatch</span>
        <span>/</span>
        <span style="color: var(--secondary);">Thoughtful home cooking, seasonal flavours &amp; unhurried suppers</span>
    </div>
    <div style="display: flex; gap: 1.5rem; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">
        <span style="color: var(--outline);">London · Cotswolds · Edinburgh</span>
        <span style="font-weight: 500;">Vol. XIV / Edition 03</span>
    </div>
</div>

<!-- Search Section -->
<div class="search-section">
    <div class="search-container">
        <div class="search-input-wrapper">
            <span class="material-symbols-outlined">search</span>
            <input type="search" placeholder="Search through our recipe archive..." id="recipe-search"/>
        </div>
        <div style="font-size: 0.8125rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--secondary);">
            <span style="color: var(--outline);">Catalogued:</span> 
            <strong style="color: var(--primary);"><?= count($recipes); ?> Kitchen Recipes</strong>
        </div>
    </div>
</div>

<!-- Main Recipe Grid Container -->
<main class="recipe-page">
    <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 2.5rem;">
        <div>
            <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.2em; color: var(--secondary);">THE PANTRY INDEX</span>
            <h1 style="font-size: 2rem; font-weight: 700; margin-top: 0.25rem; letter-spacing: -0.02em;">Freshly Tested Recipes &amp; Staples</h1>
        </div>
        <p style="font-size: 0.875rem; color: var(--secondary); max-width: 320px;">
            Pulled straight from our database tables and prepped for your kitchen counter.
        </p>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="error-notice" role="alert">
            <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <div class="recipe-grid">
        <?php if (!empty($recipes)): ?>
            <?php foreach ($recipes as $recipe): ?>
                <article class="recipe-card">
                    <div class="recipe-card-img-placeholder">
                        <span class="material-symbols-outlined" style="font-size: 48px; color: var(--outline); margin-bottom: 0.5rem;">restaurant_menu</span>
                        <h2 style="font-size: 1.25rem; font-weight: 600;"><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <div style="position: absolute; top: 0.75rem; left: 0.75rem; background: rgba(250,249,245,0.9); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em;">
                            <?= htmlspecialchars($recipe['category'], ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <div style="position: absolute; bottom: 0.75rem; right: 0.75rem; background: rgba(255,255,255,0.9); padding: 0.125rem 0.375rem; border-radius: 4px; font-size: 0.75rem; color: var(--secondary);">
                            Rec. #<?= str_pad($recipe['recipe_id'], 3, '0', STR_PAD_LEFT); ?>
                        </div>
                    </div>
                    <div class="recipe-card-body">
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--secondary); margin-bottom: 0.5rem;">
                                <span>Recipe Entry</span>
                                <span style="color: var(--outline);">Serves <?= (int)$recipe['servings']; ?></span>
                            </div>
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;"><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p style="font-size: 0.875rem; color: var(--secondary); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                        </div>
                        <div class="recipe-meta-bar">
                            <div style="display: flex; align-items: center; gap: 0.375rem;">
                                <span class="material-symbols-outlined" style="font-size: 16px;">schedule</span>
                                <span>Prep <?= (int)$recipe['prep_time_mins']; ?>m · Cook <?= (int)$recipe['cook_time_mins']; ?>m</span>
                            </div>
                            <a href="views/recipes/detail.php?id=<?= (int)$recipe['recipe_id']; ?>" style="text-decoration: none; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 0.25rem;">
                                <span>View</span>
                                <span class="material-symbols-outlined" style="font-size: 14px;">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--secondary);">No recipes found in our pantry. Do check back once we've stocked up.</p>
        <?php endif; ?>
    </div>
</main>

<?php 
// Include pure CSS footer
include __DIR__ . '/includes/footer.php'; 
?>