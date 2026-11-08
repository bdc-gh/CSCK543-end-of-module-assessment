-- 1. Create and select the database
CREATE DATABASE IF NOT EXISTS recipe_app;
USE recipe_app;

-- 2. Users Table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Recipes Table
CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(100) NOT NULL, 
    ingredients TEXT NOT NULL,      
    steps TEXT NOT NULL,            
    prep_time_mins INT NOT NULL,
    cook_time_mins INT NOT NULL,
    servings INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 4. Ratings Table
CREATE TABLE ratings (
    rating_id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    rating_score INT NOT NULL, 
    comment TEXT,
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 5. Saved Recipes Table (Favourites)
CREATE TABLE saved_recipes (
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    PRIMARY KEY (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
);

USE recipe_app;

INSERT INTO users (name, email, password_hash)
VALUES ('chef', 'chef@example.com', 'hashed_password_string');

INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings) 
VALUES (
    1,
    'Ultimate Spaghetti Bolognese',
    'A rich, slow-cooked traditional beef bolognese sauce served over spaghetti.',
    'Main, Italian, Pasta',
    '1 tbsp olive oil\n500g beef mince\n2 onions, chopped\n2 carrots, chopped\n2x 400g tinned tomatoes\n125ml red wine\n75g parmesan cheese',
    'Step 1 (10 mins): Heat oil and fry bacon until crisp.\nStep 2 (10 mins): Add onion, carrot, celery and cook until soft.\nStep 3 (5 mins): Add mince and brown.\nStep 4 (75 mins): Add tomatoes, wine, herbs and simmer.\nStep 5 (10 mins): Cook spaghetti and mix into sauce.',
    20,
    85,
    4
);

select * from recipes;