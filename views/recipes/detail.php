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
?>
<!DOCTYPE html>
<html class="bg-surface" lang="en-GB">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $recipe ? htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8') : 'Recipe Not Found'; ?> · RecipeApp Kitchen</title>
    
    <!-- Typography & Icons -->
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
                    "fontFamily": { "label-md": [ "Plus Jakarta Sans" ], "headline-sm": [ "Plus Jakarta Sans" ], "display-lg-mobile": [ "Plus Jakarta Sans" ], "label-sm": [ "Plus Jakarta Sans" ], "label-lg": [ "Plus Jakarta Sans" ], "headline-md": [ "Plus Jakarta Sans" ], "body-sm": [ "Plus Jakarta Sans" ], "display-lg": [ "EB Garamond" ], "headline-lg-mobile": [ "Plus Jakarta Sans" ], "body-md": [ "Plus Jakarta Sans" ], "headline-lg": [ "Plus Jakarta Sans" ], "body-lg": [ "Plus Jakarta Sans" ] } 
                } 
            } 
        };
    </script>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased selection:bg-secondary-container selection:text-on-secondary-fixed">
    
    <!-- Navigation Header -->
    <header class="fixed top-0 inset-x-0 z-50 bg-surface/90 backdrop-blur-md shadow-[0_1px_8px_rgba(48,51,47,0.03)]">
        <div class="max-w-[1360px] mx-auto px-margin-mobile lg:px-margin h-20 flex items-center justify-between gap-space-lg">
            <div class="flex items-center gap-space-md shrink-0">
                <a class="flex flex-col" href="../../index.php">
                    <span class="font-headline-sm text-headline-sm tracking-tight text-primary leading-none">RecipeApp</span>
                    <span class="font-label-sm text-label-sm tracking-[0.2em] text-on-surface-variant uppercase mt-1">Kitchen Journal</span>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-8 lg:gap-10">
                <a class="uppercase tracking-[0.12em] transition-colors py-1 text-on-surface-variant hover:text-primary" href="index.php">Recipe Archive</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-primary transition-colors py-1" href="../../index.php">Return Home</a>
            </nav>
            <div class="flex items-center gap-space-md shrink-0">
                <a class="font-label-sm text-label-sm uppercase tracking-[0.14em] text-on-surface-variant hover:text-primary transition-colors px-2 py-1" href="../auth/login.php">Sign In</a>
                <a class="hidden sm:inline-block font-label-sm text-label-sm uppercase tracking-[0.14em] bg-primary text-on-primary px-3 py-1.5 rounded transition-all hover:bg-primary-container hover:text-on-primary-container" href="../auth/register.php">Register</a>
            </div>
        </div>
    </header>

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

    <!-- Footer Component -->
    <footer class="w-full bg-surface-container-low mt-space-xl">
        <div class="max-w-[1360px] mx-auto px-margin-mobile lg:px-margin py-space-xl flex flex-col md:flex-row items-baseline justify-between gap-space-lg">
            <div class="flex flex-col gap-space-xs">
                <div class="flex items-center gap-2">
                    <span class="font-headline-md text-headline-md text-primary tracking-tight">RecipeApp</span>
                    <span class="font-label-sm text-label-sm tracking-[0.2em] text-outline uppercase">Studio</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm mt-1">Thoughtful home cooking notes, seasonal flavours, and unhurried kitchen craft.</p>
            </div>
            <div class="font-label-sm text-label-sm text-outline tracking-wider">&copy; 2026 RECIPE APP KITCHEN JOURNAL. ALL RIGHTS RESERVED.</div>
        </div>
    </footer>
</body>
</html>