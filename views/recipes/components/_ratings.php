<?php
/**
 * RecipeApp Kitchen - Recipe Ratings & Comments Component
 * Located at: views/recipes/components/_ratings.php
 */

$ratings = [];

if (isset($recipe_id) && $recipe_id > 0 && isset($pdo)) {
    try {
        $sql = "SELECT ratings.rating_score, ratings.comment, 
                       COALESCE(users.name, 'Anonymous') AS display_name
                FROM ratings 
                JOIN users ON ratings.user_id = users.user_id 
                WHERE ratings.recipe_id = :recipe_id 
                ORDER BY ratings.rating_id DESC";

        $params = [
            'recipe_id' => $recipe_id
        ];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $ratings = [];
    }
}
?>

<div class="content-block">
    <h2>
        <span class="material-symbols-outlined" style="color: var(--secondary);">rate_review</span>
        <span>Ratings & Comments</span>
    </h2>
    <div class="content-box">
        <?php if (empty($ratings)): ?>
            <p class="no-ratings-notice">No reviews or comments left for this recipe yet. Be the first to try it and share your thoughts!</p>
        <?php else: ?>
            <div class="ratings-list">
                <?php foreach ($ratings as $rating): ?>
                    <div class="rating-item">
                        <div class="rating-header">
                            <span class="rating-username"><?= htmlspecialchars($rating['display_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="rating-score">★ <?= (int)$rating['rating_score']; ?> / 5</span>
                        </div>
                        <?php if (!empty($rating['comment'])): ?>
                            <p class="rating-comment"><?= htmlspecialchars($rating['comment'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>