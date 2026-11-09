<?php
/**
 * RecipeApp Culinary Journal - Home / Landing Page
 * Connects to MySQL via PDO, fetches all recipes, and renders 
 * the dynamic accessible HTML5 layout with a distinct British artisanal tone.
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
?>
<!DOCTYPE html>
<html class="bg-surface" lang="en-GB">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <title>RecipeApp · Culinary Journal & Recipes</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <style>
        @layer base { 
            html, body { margin: 0; padding: 0; } 
            body { overscroll-behavior: none; } 
            main > :first-child { margin-top: 0 !important; } 
            main > :last-child { margin-bottom: 0 !important; } 
        } 
        ::-webkit-scrollbar { display: none; }
    </style>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = { 
            darkMode: "class", 
            theme: { 
                extend: { 
                    "colors": { 
                        "surface-container-lowest": "#ffffff", "primary-fixed": "#e1e3dd", "on-secondary-container": "#606457", "surface": "#faf9f5", "secondary": "#5c6053", "on-tertiary-fixed-variant": "#5c4035", "on-error-container": "#93000a", "surface-bright": "#faf9f5", "surface-container-highest": "#e3e2df", "secondary-fixed": "#e1e4d4", "surface-container-low": "#f4f4f0", "outline": "#757873", "surface-variant": "#e3e2df", "outline-variant": "#c5c7c1", "on-primary-fixed-variant": "#454843", "on-background": "#1b1c1a", "surface-dim": "#dbdad6", "on-primary-fixed": "#191c19", "on-error": "#ffffff", "tertiary": "#2d180e", "on-tertiary": "#ffffff", "primary-fixed-dim": "#c5c7c1", "on-secondary-fixed-variant": "#44483c", "tertiary-fixed": "#ffdbcd", "background": "#faf9f5", "inverse-surface": "#2f312e", "on-surface-variant": "#444843", "on-tertiary-container": "#b69284", "surface-container-high": "#e9e8e4", "surface-tint": "#5c5f5a", "on-secondary": "#ffffff", "inverse-on-surface": "#f2f1ed", "on-primary": "#ffffff", "on-primary-container": "#999b96", "secondary-container": "#dee1d1", "on-secondary-fixed": "#191d13", "tertiary-fixed-dim": "#e5beaf", "surface-container": "#efeeea", "primary": "#1b1e1a", "secondary-fixed-dim": "#c4c8b8", "error-container": "#ffdad6", "primary-container": "#30332f", "error": "#ba1a1a", "on-tertiary-fixed": "#2b160d", "inverse-primary": "#c5c7c1", "tertiary-container": "#452c22", "on-surface": "#1b1c1a" 
                    }, 
                    "borderRadius": { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" }, 
                    "spacing": { "space-sm": "0.5rem", "gutter": "1.5rem", "space-md": "1rem", "margin": "3rem", "gutter-mobile": "1rem", "space-xl": "3rem", "margin-mobile": "1.25rem", "space-lg": "1.75rem", "space-xs": "0.25rem" }, 
                    "fontFamily": { "label-md": [ "Plus Jakarta Sans" ], "headline-sm": [ "EB Garamond" ], "display-lg-mobile": [ "EB Garamond" ], "label-sm": [ "Plus Jakarta Sans" ], "label-lg": [ "Plus Jakarta Sans" ], "headline-md": [ "EB Garamond" ], "body-sm": [ "Plus Jakarta Sans" ], "display-lg": [ "EB Garamond" ], "headline-lg-mobile": [ "EB Garamond" ], "body-md": [ "Plus Jakarta Sans" ], "headline-lg": [ "EB Garamond" ], "body-lg": [ "Plus Jakarta Sans" ] } 
                } 
            } 
        };
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-secondary-container selection:text-on-secondary-fixed">
    
    <!-- Header -->
    <header class="fixed top-0 inset-x-0 z-50 bg-surface/90 backdrop-blur-md shadow-[0_1px_8px_rgba(48,51,47,0.03)]">
        <div class="max-w-[1360px] mx-auto px-margin-mobile lg:px-margin h-20 flex items-center justify-between gap-space-lg">
            <div class="flex items-center gap-space-md shrink-0">
                <a class="flex flex-col" href="index.php">
                    <span class="font-headline-sm text-headline-sm tracking-tight text-primary leading-none">RecipeApp</span>
                    <span class="font-label-sm text-label-sm tracking-[0.2em] text-on-surface-variant uppercase mt-1">Kitchen Journal</span>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-8 lg:gap-10">
                <a aria-current="page" class="uppercase tracking-[0.12em] transition-colors py-1 text-primary font-semibold border-b border-primary" href="index.php">Recipes</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-on-surface transition-colors py-1" href="#">Seasons</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-on-surface transition-colors py-1" href="#">Techniques</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-on-surface transition-colors py-1" href="#">Journal</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-on-surface transition-colors py-1" href="#">About</a>
            </nav>
            <div class="flex items-center gap-space-md shrink-0">
                <a class="font-label-sm text-label-sm uppercase tracking-[0.14em] text-on-surface-variant hover:text-primary transition-colors px-2 py-1" href="views/auth/login.php">Sign In</a>
                <a class="hidden sm:inline-block font-label-sm text-label-sm uppercase tracking-[0.14em] bg-primary text-on-primary px-3 py-1.5 rounded transition-all hover:bg-primary-container hover:text-on-primary-container" href="views/auth/register.php">Register</a>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-on-primary text-[18px]">person</span>
                </div>
            </div>
        </div>
    </header>

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
                            <span class="bg-surface-container px-3 py-1.5 rounded font-medium text-primary"><?= count($recipes); ?> Kitchen Monographs</span>
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

    <!-- Footer -->
    <footer class="w-full bg-surface-container-low mt-space-xl">
        <div class="max-w-[1360px] mx-auto px-margin-mobile lg:px-margin py-space-xl flex flex-col md:flex-row items-baseline justify-between gap-space-lg">
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-2">
                    <span class="font-headline-md text-headline-md text-primary tracking-tight">RecipeApp</span>
                    <span class="font-label-sm text-label-sm tracking-[0.2em] text-outline uppercase">Kitchen</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm mt-1">Thoughtful home cooking notes, seasonal eating, and unhurried culinary traditions.</p>
            </div>
            <div class="font-label-sm text-label-sm text-outline tracking-wider">&copy; 2026 RECIPE APP KITCHEN JOURNAL. ALL RIGHTS RESERVED.</div>
        </div>
    </footer>
</body>
</html>