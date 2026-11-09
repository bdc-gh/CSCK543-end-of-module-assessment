<?php
/**
 * RecipeApp Home / Landing Page
 * Connects to MySQL fetches all recipes, and renders 
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
    $error_message = "We couldn't quite reach the pantry ledger at the moment. Please pop back shortly.";
}

// 3. Set dynamic page title & include header
$page_title = "RecipeApp · Recipes";
include __DIR__ . '/includes/header.php';
?>

    <main class="w-full pt-20 bg-surface min-h-[calc(100vh-14rem)]">
        <div class="flex flex-col w-full">
            
            <!-- Seasonal Ribbon -->
            <section class="w-full bg-surface-container-low">
                <div class="max-w-[1360px] mx-auto px-margin-mobile lg:px-margin py-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                        <span class="font-label-sm text-label-sm uppercase tracking-[0.22em] text-on-surface-variant">Kitchen Dispatch</span>
                        <span class="text-outline-variant font-light">/</span>
                        <span class="font-body-sm text-body-sm text-secondary">Thoughtful home cooking, seasonal flavours &amp; unhurried suppers</span>
                    </div>
                    <div class="hidden sm:flex items-center gap-6">
                        <span class="font-label-sm text-label-sm tracking-[0.15em] text-outline uppercase">London · Cotswolds · Edinburgh</span>
                        <span class="font-label-sm text-label-sm text-on-surface font-medium">Vol. XIV / Edition 03</span>
                    </div>
                </div>
            </section>

            <!-- Search Bar Section -->
            <section class="w-full px-margin-mobile lg:px-margin py-8 bg-surface-container-low/60">
                <div class="max-w-[1360px] mx-auto flex flex-col gap-6">
                    <div class="w-full grid grid-cols-1 lg:grid-cols-12 gap-4 items-center">
                        <div class="lg:col-span-8 relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[20px] text-outline pointer-events-none">search</span>
                            <input class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline text-body-md font-body-md pl-12 pr-10 py-3.5 rounded shadow-sm outline-none transition-shadow focus:shadow-md" id="recipe-search" placeholder="Search through our recipe archive..." type="search"/>
                        </div>
                        <div class="lg:col-span-4 flex items-center justify-between lg:justify-end gap-3 text-secondary font-label-sm text-label-sm tracking-wider uppercase">
                            <span class="text-outline">Catalogued:</span>
                            <span class="bg-surface-container px-3 py-1.5 rounded font-medium text-primary"><?= count($recipes); ?> Kitchen Recipes</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dynamic Recipe Grid -->
            <section class="w-full px-margin-mobile lg:px-margin py-16">
                <div class="max-w-[1360px] mx-auto">
                    <div class="flex flex-col sm:flex-row items-baseline justify-between mb-12">
                        <div>
                            <span class="font-label-sm text-label-sm uppercase tracking-[0.24em] text-secondary">THE PANTRY INDEX</span>
                            <h2 class="font-headline-lg text-headline-lg text-primary tracking-tight mt-1">Freshly Tested Recipes &amp; Staples</h2>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm mt-3 sm:mt-0">
                            Pulled straight from our database tables and prepped for your kitchen counter.
                        </p>
                    </div>

                    <?php if (!empty($error_message)): ?>
                        <div class="p-4 mb-6 bg-error-container text-on-error-container rounded" role="alert">
                            <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
                        <?php if (!empty($recipes)): ?>
                            <?php foreach ($recipes as $recipe): ?>
                                <article class="group flex flex-col bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                    <div class="relative w-full aspect-[3/2] overflow-hidden bg-surface-container flex items-center justify-center p-6 text-center">
                                        <div class="absolute inset-0 bg-surface-container flex flex-col items-center justify-center p-4">
                                            <span class="material-symbols-outlined text-[48px] text-outline mb-2">restaurant_menu</span>
                                            <span class="font-headline-sm text-headline-sm text-primary"><?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        </div>
                                        <div class="absolute top-3 left-3 bg-surface/90 backdrop-blur-sm px-2.5 py-1 rounded text-primary font-label-sm text-label-sm uppercase tracking-widest z-10">
                                            <?= htmlspecialchars($recipe['category'], ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                        <div class="absolute bottom-3 right-3 bg-surface-container-lowest/90 backdrop-blur-sm px-2 py-0.5 rounded text-secondary font-label-sm text-label-sm tracking-wide z-10">
                                            Rec. #<?= str_pad($recipe['recipe_id'], 3, '0', STR_PAD_LEFT); ?>
                                        </div>
                                    </div>
                                    <div class="p-6 flex flex-col flex-1 justify-between gap-6">
                                        <div class="flex flex-col gap-2.5">
                                            <div class="flex items-center justify-between">
                                                <span class="font-label-sm text-label-sm uppercase tracking-[0.18em] text-secondary">Recipe Entry</span>
                                                <span class="font-body-sm text-body-sm text-outline">Serves <?= (int)$recipe['servings']; ?></span>
                                            </div>
                                            <h3 class="font-headline-md text-headline-md text-primary group-hover:text-tertiary-container transition-colors leading-tight">
                                                <?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>
                                            </h3>
                                            <p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2 mt-1 leading-relaxed">
                                                <?= htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8'); ?>
                                            </p>
                                        </div>
                                        <div class="pt-4 bg-surface-container-low px-4 py-3 rounded flex items-center justify-between">
                                            <div class="flex items-center gap-2 text-secondary">
                                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                                <span class="font-label-sm text-label-sm tracking-wider uppercase">Prep <?= (int)$recipe['prep_time_mins']; ?>m · Cook <?= (int)$recipe['cook_time_mins']; ?>m</span>
                                            </div>
                                            <a class="inline-flex items-center gap-1 font-label-sm text-label-sm uppercase tracking-[0.14em] text-primary group-hover:text-tertiary-container transition-colors" href="views/recipes/detail.php?id=<?= (int)$recipe['recipe_id']; ?>">
                                                <span>View</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-on-surface-variant">No recipes found in our pantry ledger yet. Do check back once we've stocked up.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

        </div>
    </main>

<?php 
// 4. Include modular footer
include __DIR__ . '/includes/footer.php'; 
?>