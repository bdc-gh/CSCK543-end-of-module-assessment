
<?php
// Start the session if it is not already active
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Connect to the database
require_once __DIR__ . '/../../config/database.php';

// Only logged-in users can save favourites
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/auth/login.php');
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}
// Validate the CSRF security token
if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    exit('Invalid security token. Please refresh the page and try again.');
}

// Get and validate the recipe ID
$recipeId = filter_input(INPUT_POST, 'recipe_id', FILTER_VALIDATE_INT);

if (!$recipeId || $recipeId < 1) {
    http_response_code(400);
    exit('Invalid recipe ID.');
}

// Check that the recipe exists
$stmt = $pdo->prepare(
    'SELECT recipe_id FROM recipes WHERE recipe_id = ?'
);
$stmt->execute([$recipeId]);

if (!$stmt->fetchColumn()) {
    http_response_code(404);
    exit('Recipe not found.');
}

// Check whether this recipe is already saved
$stmt = $pdo->prepare(
    'SELECT 1 FROM saved_recipes WHERE user_id = ? AND recipe_id = ?'
);
$stmt->execute([$_SESSION['user_id'], $recipeId]);

if ($stmt->fetchColumn()) {
    // Remove it if it is already a favourite
    $stmt = $pdo->prepare(
        'DELETE FROM saved_recipes WHERE user_id = ? AND recipe_id = ?'
    );
    $stmt->execute([$_SESSION['user_id'], $recipeId]);
} else {
    // Save it if it is not already a favourite
    $stmt = $pdo->prepare(
        'INSERT INTO saved_recipes (user_id, recipe_id) VALUES (?, ?)'
    );
    $stmt->execute([$_SESSION['user_id'], $recipeId]);
}

// Return to the recipe archive
header('Location: /views/recipes/index.php');
exit;
