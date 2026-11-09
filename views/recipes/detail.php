<?php
/**
 * RecipeApp Kitchen Journal - Single Recipe Detail View
 * Located at: views/recipes/detail.php
 * Fetches and displays an individual recipe monograph based on the passed URL query ID.
 */

// 1. Connect to the database
require_once __DIR__ . '/../../config/database.php';

// 2. Retrieve and sanitize the recipe ID from the URL parameter (?id=X)
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
        $error_notice = "A database error occurred while retrieving this monograph.";
    }
} else {
    $error_notice = "No valid recipe identifier was provided in the address.";
}

// 3. Set dynamic page title & include the modular header
$page_title = $recipe ? htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') . " · RecipeApp Kitchen" : "Recipe Not Found · RecipeApp Kitchen";
include __DIR__ . '/../../includes/header.php';
?>

    <!-- Main Content Area -->
    <main class="w-full pt-28 pb-20 bg-surface min-h-[calc(100vh-14rem)]">
        <div class="max-w-[1000px] mx-auto px-margin-mobile lg:px-margin">
            
            <?php if (!empty($error_notice)): ?>
                <!-- Error State -->
                <div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm text-center">
                    <span class="material-symbols-outlined text-[48px] text-outline mb-3">error_outline</span>
                    <h1 class="font-headline-md text-headline-md text-primary mb-2">Monograph Unavailable</h1>
                    <p class="font-body-md text-on-surface-variant mb-6"><?= htmlspecialchars($error_notice, ENT_QUOTES, 'UTF-8'); ?></p>
                    <a href="index.php" class="inline-flex items-center gap-2 bg-primary text-on-primary font-label-md text-label-md uppercase tracking-[0.14em] px-5 py-3 rounded hover:bg-primary-container transition-all">
                        <span>Return to Archive</span>
                    </a>
                </div>
            <?php elseif ($recipe): ?>
                <!-- Back Link -->
                <div class="mb-6">
                    <a href="index.php" class="inline-flex items-center gap-1 font-label-sm text-label-sm uppercase tracking-[0.14em] text-secondary hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                        <span>Back to Archive</span>
                    </a>
                </div>

                <!-- Recipe Monograph Card -->
                <article class="bg-surface-container-lowest rounded-2xl p-8 lg:p-12 shadow-sm flex flex-col gap-8">
                    
                    <!-- Header Info -->
                    <div class="flex flex-col gap-3 pb-8 border-b border-surface-variant">
                        <div class="flex items-center justify-between">
                            <span class="bg-surface-container px-3 py-1 rounded text-primary font-label-sm text-label-sm uppercase tracking-widest">
                                <?= htmlspecialchars($recipe['category'], ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                            <span class="text-outline font-label-sm text-label-sm uppercase tracking-wider">
                                Ref. #<?= str_pad($recipe['recipe_id'], 3, '0', STR_PAD_LEFT); ?>
                            </span>
                        </div>
                        
                        <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight mt-2">
                            <?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>
                        </h1>
                        
                        <p class="font-body-lg text-body-lg text-secondary leading-relaxed mt-1">
                            <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>

                    <!-- Meta Grid (Prep, Cook, Servings) -->
                    <div class="grid grid-cols-3 gap-4 bg-surface-container-low p-6 rounded-xl text-center">
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Prep Time</span>
                            <span class="font-headline-sm text-headline-sm text-primary"><?= (int)$recipe['prep_time_mins']; ?> mins</span>
                        </div>
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Cook Time</span>
                            <span class="font-headline-sm text-headline-sm text-primary"><?= (int)$recipe['cook_time_mins']; ?> mins</span>
                        </div>
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Portions</span>
                            <span class="font-headline-sm text-headline-sm text-primary"><?= (int)$recipe['servings']; ?> serves</span>
                        </div>
                    </div>

                    <!-- Ingredients Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-headline-md text-headline-md text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-secondary">checklist</span>
                            <span>Pantry Ingredients</span>
                        </h2>
                        <div class="bg-surface-container-lowest border border-surface-variant p-6 rounded-xl font-body-md text-on-surface whitespace-pre-line leading-relaxed">
                            <?= htmlspecialchars($recipe['ingredients'] ?? 'Ingredients list not provided for this entry.', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    </div>

                    <!-- Method / Instructions Section -->
                    <div class="flex flex-col gap-4">
                        <h2 class="font-headline-md text-headline-md text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-secondary">soup_kitchen</span>
                            <span>Preparation Method</span>
                        </h2>
                        <div class="bg-surface-container-lowest border border-surface-variant p-6 rounded-xl font-body-md text-on-surface whitespace-pre-line leading-relaxed">
                            <?= htmlspecialchars($recipe['steps'] ?? 'Preparation steps not provided for this entry.', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    </div>

                </article>
            <?php endif; ?>

        </div>
    </main>

<?php 
// 4. Include the modular footer
include __DIR__ . '/../../includes/footer.php'; 
?>