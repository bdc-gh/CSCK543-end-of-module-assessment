
<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Generate a CSRF security token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once dirname(__DIR__, 2) . '/config/database.php';
// Get the search term submitted by the user
$search = trim($_GET['search'] ?? '');
// Get the selected dietary filter
$dietary = $_GET['dietary'] ?? '';
// Get the maximum total cooking time
$maxTime = filter_input(INPUT_GET, 'max_time', FILTER_VALIDATE_INT);
// Get the minimum rating filter
$minRating = filter_input(INPUT_GET, 'min_rating', FILTER_VALIDATE_FLOAT);
// Get the selected sorting option
$sort = $_GET['sort'] ?? 'newest';
// Build the recipe search query
$sql = "SELECT recipes.recipe_id, recipes.title, recipes.description,
               recipes.category, recipes.prep_time_mins,
               recipes.cook_time_mins, recipes.servings,
               recipes.image_filename,
               rating_summary.average_rating
        FROM recipes
        LEFT JOIN (
            SELECT recipe_id, AVG(rating_score) AS average_rating
            FROM ratings
            GROUP BY recipe_id
        ) AS rating_summary
        ON recipes.recipe_id = rating_summary.recipe_id";

$params = [];
// Get the current user's saved recipes
$savedRecipeIds = [];

if (isset($_SESSION['user_id'])) {
    $savedStmt = $pdo->prepare(
        'SELECT recipe_id FROM saved_recipes WHERE user_id = ?'
    );

    $savedStmt->execute([$_SESSION['user_id']]);

    $savedRecipeIds = array_map(
        'intval',
        $savedStmt->fetchAll(PDO::FETCH_COLUMN)
    );
}

$conditions = [];

if ($search !== '') {
    $conditions[] = "(title LIKE :title_search
                      OR ingredients LIKE :ingredient_search
                      OR category LIKE :category_search)";

    $searchTerm = '%' . $search . '%';

    $params['title_search'] = $searchTerm;
    $params['ingredient_search'] = $searchTerm;
    $params['category_search'] = $searchTerm;
}

// Dietary filters
if ($dietary === 'vegan') {
    $conditions[] = "category LIKE '%Vegan%'";
} elseif ($dietary === 'vegetarian') {
    $conditions[] = "(category LIKE '%Vegetarian%'
                      OR category LIKE '%Vegan%')";
} elseif ($dietary === 'meat') {
    $conditions[] = "(category NOT LIKE '%Vegan%'
                      AND category NOT LIKE '%Vegetarian%'
                      AND (ingredients LIKE '%beef%'
                           OR ingredients LIKE '%lamb%'
                           OR ingredients LIKE '%chicken%'
                           OR ingredients LIKE '%pork%'))";
}
// Maximum total cooking time filter
if ($maxTime !== false && $maxTime !== null && $maxTime > 0) {
    $conditions[] = "(prep_time_mins + cook_time_mins) <= :max_time";
    $params['max_time'] = $maxTime;
}
// Minimum average rating filter
if ($minRating !== false && $minRating !== null && $minRating >= 1 && $minRating <= 5) {
    $conditions[] = "rating_summary.average_rating >= :min_rating";
    $params['min_rating'] = $minRating;
}
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Apply recipe sorting
$sortOptions = [
    'newest' => 'recipes.created_at DESC',
    'highest_rated' => 'rating_summary.average_rating DESC',
    'quickest' => '(recipes.prep_time_mins + recipes.cook_time_mins) ASC',
    'alphabetical' => 'recipes.title ASC'
];

if (!array_key_exists($sort, $sortOptions)) {
    $sort = 'newest';
}

$sql .= " ORDER BY " . $sortOptions[$sort];

try {
    // Retrieve recipes from the database
      $stmt = $pdo->prepare($sql);
$stmt->execute($params);

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

<?php
$page_title = "Browse Recipes · RecipeApp";
include __DIR__ . '/../../includes/header.php';
?>

<main class="recipe-page">

   <div class="archive-intro">
    <h1>Discover Recipes</h1>
    <p>Explore delicious recipes and find your next favourite meal.</p>
</div>
    <section aria-labelledby="recipe-heading">

        <h2 id="recipe-heading">All Recipes</h2>
        <form method="GET" action="index.php" class="recipe-filter-form">
           <div class="filter-field">
    <label for="sort">Sort recipes</label>
    <select name="sort" id="sort">
        <option value="newest" <?= $sort === 'newest' ? 'selected' : ''; ?>>Newest first</option>
        <option value="highest_rated" <?= $sort === 'highest_rated' ? 'selected' : ''; ?>>Highest rated</option>
        <option value="quickest" <?= $sort === 'quickest' ? 'selected' : ''; ?>>Quickest first</option>
        <option value="alphabetical" <?= $sort === 'alphabetical' ? 'selected' : ''; ?>>Alphabetical (A–Z)</option>
    </select>
</div>

<div class="filter-field">
    <label for="min_rating">Minimum rating</label>
    <select name="min_rating" id="min_rating">
        <option value="">Any rating</option>
        <option value="3" <?= $minRating == 3 ? 'selected' : ''; ?>>3 stars or above</option>
        <option value="4" <?= $minRating == 4 ? 'selected' : ''; ?>>4 stars or above</option>
        <option value="5" <?= $minRating == 5 ? 'selected' : ''; ?>>5 stars only</option>
    </select>
</div>

<div class="filter-field">
    <label for="max_time">Maximum cooking time</label>
    <select name="max_time" id="max_time">
        <option value="">Any time</option>
        <option value="15" <?= $maxTime == 15 ? 'selected' : ''; ?>>15 minutes</option>
        <option value="30" <?= $maxTime == 30 ? 'selected' : ''; ?>>30 minutes</option>
        <option value="45" <?= $maxTime == 45 ? 'selected' : ''; ?>>45 minutes</option>
        <option value="60" <?= $maxTime == 60 ? 'selected' : ''; ?>>60 minutes</option>
    </select>
</div>

<div class="filter-field">
    <label for="dietary">Dietary preference</label>
    <select name="dietary" id="dietary">
        <option value="">All recipes</option>
        <option value="vegan" <?= $dietary === 'vegan' ? 'selected' : ''; ?>>Vegan</option>
        <option value="vegetarian" <?= $dietary === 'vegetarian' ? 'selected' : ''; ?>>Vegetarian</option>
        <option value="meat" <?= $dietary === 'meat' ? 'selected' : ''; ?>>Meat</option>
    </select>
</div>

<?php if ($search !== ''): ?>
    <input type="hidden" name="search" value="<?= escapeRecipe($search); ?>">
<?php endif; ?>




    <button type="submit">Apply filter</button>

</form>

        <?php if (!empty($databaseError)): ?>

            <p role="alert">
                We couldn't load the recipes. Please try again later.
            </p>

        <?php elseif (empty($recipes)): ?>

            <p>No recipes are available yet.</p>

        <?php else: ?>

            <div class="recipe-grid">

                <?php foreach ($recipes as $recipe): ?>
<div class="recipe-card-item">
                   
<a class="recipe-card-link" href="detail.php?id=<?= (int) $recipe['recipe_id']; ?>">
    <article class="recipe-card">
    <?php if (!empty($recipe['image_filename'])): ?>
    <img
        src="../../assets/images/recipes/<?= htmlspecialchars($recipe['image_filename'], ENT_QUOTES, 'UTF-8'); ?>"
        alt="<?= htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?>"
        class="recipe-card-image"
    >
<?php endif; ?>

        <h3>
            <?= escapeRecipe($recipe['title']); ?>
        </h3>
        <?php if ($recipe['average_rating'] !== null): ?>
    <p>
        <strong>Rating:</strong>
        <?= number_format((float) $recipe['average_rating'], 1); ?> / 5
    </p>
<?php else: ?>
    <p><strong>Rating:</strong> Not rated yet</p>
<?php endif; ?>

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
        <?= in_array((int) $recipe['recipe_id'], $savedRecipeIds, true)
            ? 'Remove favourite'
            : 'Save to favourites'; ?>
    </button>
</form>
</div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</main>

</body>
</html>
