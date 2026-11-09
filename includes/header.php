<?php
/**
 * Provides consistent header across pages.
 */
// Determine if we are inside a subdirectory to adjust relative paths
$is_subdirectory = file_exists('../../config/database.php') || file_exists('../config/database.php');
$base_path = $is_subdirectory ? '../../' : '';
?>
<!DOCTYPE html>
<html class="bg-surface" lang="en-GB">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= isset($page_title) ? htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') : 'RecipeApp · Kitchen Journal'; ?></title>
    
    <!-- Typography & Icons -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
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
                    "fontFamily": { 
                        "label-md": [ "Plus Jakarta Sans" ], "headline-sm": [ "Plus Jakarta Sans" ], 
                        "display-lg-mobile": [ "Plus Jakarta Sans" ], "label-sm": [ "Plus Jakarta Sans" ], 
                        "label-lg": [ "Plus Jakarta Sans" ], "headline-md": [ "Plus Jakarta Sans" ], 
                        "body-sm": [ "Plus Jakarta Sans" ], "display-lg": [ "Plus Jakarta Sans" ], 
                        "headline-lg-mobile": [ "Plus Jakarta Sans" ], "body-md": [ "Plus Jakarta Sans" ], 
                        "headline-lg": [ "Plus Jakarta Sans" ], "body-lg": [ "Plus Jakarta Sans" ] 
                    } 
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
                <a class="flex flex-col" href="<?= $base_path; ?>index.php">
                    <span class="font-headline-sm text-headline-sm tracking-tight text-primary leading-none">RecipeApp</span>
                    <span class="font-label-sm text-label-sm tracking-[0.2em] text-on-surface-variant uppercase mt-1">Kitchen Journal</span>
                </a>
            </div>
            <nav class="hidden md:flex items-center gap-8 lg:gap-10">
                <a class="uppercase tracking-[0.12em] transition-colors py-1 text-primary font-semibold border-b border-primary" href="<?= $base_path; ?>views/recipes/index.php">Recipe Archive</a>
                <a class="font-label-md text-label-md uppercase tracking-[0.12em] text-on-surface-variant hover:text-primary transition-colors py-1" href="<?= $base_path; ?>index.php">Return Home</a>
            </nav>
            <div class="flex items-center gap-space-md shrink-0">
                <a class="font-label-sm text-label-sm uppercase tracking-[0.14em] text-on-surface-variant hover:text-primary transition-colors px-2 py-1" href="<?= $base_path; ?>views/auth/login.php">Sign In</a>
                <a class="hidden sm:inline-block font-label-sm text-label-sm uppercase tracking-[0.14em] bg-primary text-on-primary px-3 py-1.5 rounded transition-all hover:bg-primary-container hover:text-on-primary-container" href="<?= $base_path; ?>views/auth/register.php">Register</a>
            </div>
        </div>
    </header>