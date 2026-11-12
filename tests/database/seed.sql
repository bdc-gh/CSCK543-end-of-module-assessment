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
    image_filename VARCHAR(255),
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

-- 1. Ultimate Spaghetti Bolognese
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Ultimate Spaghetti Bolognese',
    'A rich, slow-cooked traditional beef bolognese sauce served over spaghetti.',
    'Main, Italian, Pasta',
    '1 tbsp olive oil\n500g beef mince\n2 onions, chopped\n2 carrots, chopped\n2x 400g tinned tomatoes\n125ml red wine\n75g parmesan cheese',
    'Step 1 (10 mins): Heat oil and fry bacon until crisp.\nStep 2 (10 mins): Add onion, carrot, celery and cook until soft.\nStep 3 (5 mins): Add mince and brown.\nStep 4 (75 mins): Add tomatoes, wine, herbs and simmer.\nStep 5 (10 mins): Cook spaghetti and mix into sauce.',
    20,
    85,
    4,
    'spaghetti_bolognese.jpg'
);

-- 2. Vegan American Pancakes
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Vegan American Pancakes',
    'Extremely fluffy, thick American-style vegan pancakes served with maple syrup.',
    'Breakfast, Vegan, Dessert',
    '150g plain flour\n1 tbsp baking powder\n150ml oat milk\n2 tbsp maple syrup\n0.5 tsp vanilla extract\n0.5 tbsp melted coconut oil\n2 tbsp coconut oil for frying',
    'Step 1: Put flour and baking powder in a bowl and stir together. Mix milk, maple syrup, vanilla, and coconut oil.\nStep 2: Gradually stir wet ingredients into dry until you have a smooth batter. Let sit for 3 minutes.\nStep 3: Heat a non-stick frying pan with coconut oil over medium heat.\nStep 4: Pour batter to form 10cm pancakes. Cook until bubbles form, then flip and cook for 2-3 minutes.\nStep 5: Serve warm drizzled with maple syrup.',
    10,
    15,
    4,
    'vegan_pancakes.jpg'
);

-- 3. Easy Lamb Biryani
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Easy Lamb Biryani',
    'A quick and flavorful spiced lamb and rice dish bursting with aromatic spices.',
    'Main, Curry, Rice',
    '500g lamb shoulder, cubed\n300g basmati rice\n2 tbsp vegetable oil\n2 onions, sliced\n3 garlic cloves, crushed\n2 tbsp biryani paste\n400ml lamb stock',
    'Step 1: Heat oil in a large pan and fry onions until golden brown.\nStep 2: Add garlic and lamb, sealing the meat on all sides.\nStep 3: Stir in biryani paste and cook for 2 minutes.\nStep 4: Pour in lamb stock, bring to a boil, then simmer until the lamb is tender.\nStep 5: Layer with cooked basmati rice and steam until hot through.',
    20,
    45,
    4,
    'lamb_biryani.jpg'
);

-- 4. Mushroom Doner Kebab
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Mushroom Doner Kebab',
    'A meat-free mushroom doner kebab packed with spices, sauces, and fresh salad.',
    'Main, Vegetarian, Fast Food',
    '400g large oyster mushrooms\n2 tbsp olive oil\n1 tsp smoked paprika\n1 tsp ground cumin\n1 tsp garlic powder\nFlatbreads\nSalad leaves and garlic sauce',
    'Step 1: Tear oyster mushrooms into strips resembling kebab meat.\nStep 2: Toss mushrooms in olive oil, paprika, cumin, garlic powder, salt, and pepper.\nStep 3: Roast or pan-fry on high heat until dark, crispy, and reduced.\nStep 4: Serve warm wrapped in flatbreads with fresh salad and garlic sauce.',
    15,
    20,
    2,
    'mushroom_doner.jpg'
);

-- 5. Healthy Pizza
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Healthy Pizza',
    'A quick, no-yeast homemade pizza with a thin crispy base and fresh toppings.',
    'Main, Italian, Baking',
    '350g plain flour\n2.75 tsp baking powder\n1 tsp salt\n1 tbsp oil\n170ml water\nTomato passata\nMozzarella cheese\nSliced vegetables',
    'Step 1: Heat the oven to 200C/180C fan.\nStep 2: Mix flour, baking powder, and salt in a bowl. Stir in oil and water until a soft dough forms.\nStep 3: Knead on a floured surface for 3-4 minutes, then roll out into thin pizza bases.\nStep 4: Spread passata, add mozzarella and vegetables.\nStep 5: Bake on a baking sheet for 15 minutes until crisp.',
    15,
    15,
    2,
    'healthy_pizza.jpg'
);

-- 6. Couscous Salad
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Couscous Salad',
    'A light, refreshing Mediterranean-style couscous salad packed with fresh herbs, crisp vegetables, and a zesty dressing.',
    'Salad, Vegetarian, Main',
    '200g couscous\n200ml vegetable stock\n1 cucumber, diced\n200g cherry tomatoes, halved\n1 red onion, finely chopped\nHandfresh parsley and mint\n3 tbsp extra virgin olive oil\n1 lemon, juiced',
    'Step 1: Place the couscous in a large bowl, pour over the boiling vegetable stock, cover, and leave to absorb for 5 minutes.\nStep 2: Fluff the couscous with a fork and allow it to cool slightly.\nStep 3: Stir in the diced cucumber, halved cherry tomatoes, red onion, and chopped fresh herbs.\nStep 4: Whisk together the olive oil and lemon juice, pour over the salad, toss well to combine, and serve.',
    15,
    5,
    4,
    'couscous_salad.jpg'
);

-- 7. Plum Clafoutis
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Plum Clafoutis',
    'A classic French baked dessert featuring sweet caramelised plums in a rich custard batter.',
    'Dessert, French, Baking',
    '300g plums, halved and stoned\n50g cornflour\n100g ground almonds\n3 eggs\n100g caster sugar\n300g creme fraiche\n100ml milk',
    'Step 1: Heat oven to 180C and grease a round baking dish with butter.\nStep 2: Whisk cornflour, ground almonds, and a pinch of salt together.\nStep 3: In a separate large bowl, beat eggs and caster sugar until pale, then mix in the almond blend, creme fraiche, and milk.\nStep 4: Pour batter into the dish and arrange plums cut-side up on top.\nStep 5: Bake for 45 minutes until golden and just set.',
    20,
    45,
    6,
    'plum_clafoutis.jpg'
);

-- 8. Mango Pie
INSERT INTO recipes (user_id, title, description, category, ingredients, steps, prep_time_mins, cook_time_mins, servings, image_filename) 
VALUES (
    1,
    'Mango Pie',
    'A vibrant, tropical fruit pie with a buttery crust and sweet mango filling.',
    'Dessert, Baking, Sweet',
    '1 sweet pastry case, pre-baked\n4 ripe mangoes, sliced\n2 tbsp sugar\n1 tbsp lemon juice\n2 tbsp cornflour\n1 tsp vanilla extract',
    'Step 1: Preheat oven to 190C.\nStep 2: Toss sliced mangoes with sugar, lemon juice, cornflour, and vanilla extract.\nStep 3: Spoon the mango filling evenly into the pre-baked pastry case.\nStep 4: Bake for 25-30 minutes until the filling is bubbling and thickened.\nStep 5: Allow to cool completely before slicing and serving.',
    20,
    30,
    8,
    'mango_pie.jpg'
);

select * from recipes;