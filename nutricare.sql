-- Complete NutriCare Database Schema

-- Database creation
CREATE DATABASE IF NOT EXISTS NutriCare;
USE NutriCare;

-- 1. USER TABLES
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    age INT,
    gender ENUM('Male', 'Female', 'Other', 'Prefer not to say'),
    weight DECIMAL(5,2),
    height DECIMAL(5,2),
    diet_preference ENUM('Vegetarian', 'Non-Vegetarian', 'Vegan', 'Pescatarian'),
    child_mode BOOLEAN DEFAULT FALSE,
    profile_completed BOOLEAN DEFAULT FALSE,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE user_auth (
    auth_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider ENUM('email', 'google', 'facebook', 'apple') NOT NULL,
    provider_id VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 2. HEALTH PROFILE TABLES
CREATE TABLE medical_conditions (
    condition_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_conditions (
    user_condition_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    condition_id INT NOT NULL,
    severity ENUM('Mild', 'Moderate', 'Severe'),
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES medical_conditions(condition_id),
    UNIQUE KEY unique_user_condition (user_id, condition_id)
);

CREATE TABLE allergens (
    allergen_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_allergens (
    user_allergen_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    allergen_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (allergen_id) REFERENCES allergens(allergen_id),
    UNIQUE KEY unique_user_allergen (user_id, allergen_id)
);


-- 3. FOOD SYSTEM TABLES
CREATE TABLE food_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE foods (
    food_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category_id INT,
    calories DECIMAL(6,2),
    protein DECIMAL(6,2),
    carbs DECIMAL(6,2),
    fat DECIMAL(6,2),
    fiber DECIMAL(6,2),
    sodium DECIMAL(6,2),
    sugar DECIMAL(6,2),
    glycemic_index INT,
    image_url VARCHAR(255),
    is_common_allergen BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES food_categories(category_id)
);

CREATE TABLE food_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    food_id INT NOT NULL,
    condition_id INT NOT NULL,
    recommendation_type ENUM('Recommended', 'Avoid', 'Moderation') NOT NULL,
    reason TEXT NOT NULL,
    scientific_evidence TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (food_id) REFERENCES foods(food_id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES medical_conditions(condition_id) ON DELETE CASCADE,
    UNIQUE KEY unique_food_condition (food_id, condition_id)
);

CREATE TABLE food_swaps (
    swap_id INT AUTO_INCREMENT PRIMARY KEY,
    original_food_id INT NOT NULL,
    better_food_id INT NOT NULL,
    reason TEXT NOT NULL,
    benefit_description TEXT,
    condition_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (original_food_id) REFERENCES foods(food_id),
    FOREIGN KEY (better_food_id) REFERENCES foods(food_id),
    FOREIGN KEY (condition_id) REFERENCES medical_conditions(condition_id) ON DELETE SET NULL
);

CREATE TABLE user_favorites (
    favorite_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    food_id INT,
    swap_id INT,
    exercise_id INT,
    is_tried BOOLEAN DEFAULT FALSE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(food_id) ON DELETE SET NULL,
    FOREIGN KEY (swap_id) REFERENCES food_swaps(swap_id) ON DELETE SET NULL,
    CHECK (food_id IS NOT NULL OR swap_id IS NOT NULL OR exercise_id IS NOT NULL)
);

-- 4. CHILD NUTRITION TABLES
CREATE TABLE child_nutrition_recommendations (
    recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    age_group ENUM('0-3 years', '4-8 years', '9-13 years', '14-18 years') NOT NULL,
    food_id INT NOT NULL,
    recommendation TEXT NOT NULL,
    nutritional_benefits TEXT,
    serving_suggestion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (food_id) REFERENCES foods(food_id) ON DELETE CASCADE
);

-- 5. EXERCISE TABLES
CREATE TABLE exercise_types (
    exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    intensity ENUM('Low', 'Moderate', 'High'),
    duration_minutes INT,
    calories_burned DECIMAL(6,2),
    video_url VARCHAR(255),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE exercise_recommendations (
    exercise_recommendation_id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    condition_id INT NOT NULL,
    frequency VARCHAR(50) NOT NULL,
    duration_suggestion VARCHAR(100),
    notes TEXT,
    benefits TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (exercise_id) REFERENCES exercise_types(exercise_id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES medical_conditions(condition_id) ON DELETE CASCADE
);

-- 6. PREMIUM CONSULTATION TABLES
CREATE TABLE nutritionists (
    nutritionist_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    specialization VARCHAR(100),
    qualifications TEXT,
    experience_years INT,
    hourly_rate DECIMAL(8,2),
    bio TEXT,
    profile_picture VARCHAR(255),
    average_rating DECIMAL(3,2) DEFAULT 0.0,
    total_reviews INT DEFAULT 0,
    meeting_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE nutritionist_specialties (
    specialty_id INT AUTO_INCREMENT PRIMARY KEY,
    nutritionist_id INT NOT NULL,
    condition_id INT NOT NULL,
    FOREIGN KEY (nutritionist_id) REFERENCES nutritionists(nutritionist_id) ON DELETE CASCADE,
    FOREIGN KEY (condition_id) REFERENCES medical_conditions(condition_id) ON DELETE CASCADE,
    UNIQUE KEY unique_nutritionist_specialty (nutritionist_id, condition_id)
);

CREATE TABLE nutritionist_availability (
    availability_id INT AUTO_INCREMENT PRIMARY KEY,
    nutritionist_id INT NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (nutritionist_id) REFERENCES nutritionists(nutritionist_id) ON DELETE CASCADE
);

CREATE TABLE nutritionist_unavailable_dates (
    unavailable_id INT AUTO_INCREMENT PRIMARY KEY,
    nutritionist_id INT NOT NULL,
    date DATE NOT NULL,
    reason VARCHAR(255),
    FOREIGN KEY (nutritionist_id) REFERENCES nutritionists(nutritionist_id) ON DELETE CASCADE,
    UNIQUE KEY unique_nutritionist_date (nutritionist_id, date)
);


CREATE TABLE consultations (
    consultation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nutritionist_id INT NOT NULL,
    scheduled_time DATETIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    status ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') DEFAULT 'Pending',
    payment_status ENUM('Pending', 'Paid', 'Refunded') DEFAULT 'Pending',
    payment_method ENUM('Credit Card', 'Bank Transfer', 'JazzCash', 'EasyPaisa', 'Other'),
    amount DECIMAL(8,2),
    notes TEXT,
    health_documents VARCHAR(255),
    feedback TEXT,
    rating TINYINT,
    meeting_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (nutritionist_id) REFERENCES nutritionists(nutritionist_id) ON DELETE CASCADE
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    consultation_id INT NOT NULL,
    amount DECIMAL(8,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(100),
    status ENUM('Pending', 'Completed', 'Failed', 'Refunded') DEFAULT 'Pending',
    payment_details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultation_id) REFERENCES consultations(consultation_id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    consultation_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultation_id) REFERENCES consultations(consultation_id) ON DELETE CASCADE
);

-- 7. CONTACT & SUPPORT TABLES
CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'In Progress', 'Resolved') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE faqs (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. INITIAL DATA INSERTION

-- Medical Conditions
INSERT INTO medical_conditions (name, description) VALUES
('Diabetes', 'A metabolic disease that causes high blood sugar.'),
('Hypertension', 'A condition in which the force of the blood against the artery walls is too high.'),
('Heart Disease', 'A range of conditions that affect your heart.'),
('Obesity', 'A complex disease involving an excessive amount of body fat.'),
('High Cholesterol', 'High levels of cholesterol in the blood.'),
('Celiac Disease', 'An immune reaction to eating gluten.'),
('Lactose Intolerance', 'The inability to fully digest the sugar (lactose) in milk.');

-- Allergens
INSERT INTO allergens (name, description) VALUES
('Nuts', 'Tree nuts and peanuts'),
('Dairy', 'Milk and milk products'),
('Gluten', 'Protein found in wheat, barley, and rye'),
('Shellfish', 'Crustaceans and mollusks'),
('Eggs', 'Chicken eggs and products containing eggs'),
('Soy', 'Soybeans and soy products'),
('Fish', 'Fin fish'),
('Wheat', 'Wheat and wheat products');

-- Food Categories
INSERT INTO food_categories (name, description) VALUES
('Grains', 'Bread, rice, pasta, and other grain products'),
('Vegetables', 'All fresh, frozen, and canned vegetables'),
('Fruits', 'All fresh, frozen, and canned fruits'),
('Dairy', 'Milk, cheese, yogurt, and other dairy products'),
('Protein Foods', 'Meat, poultry, fish, beans, eggs, and nuts'),
('Fats & Oils', 'Butter, oils, and other fats'),
('Sweets', 'Sugar, candy, and other sweets'),
('Legumes', 'Beans, lentils, and peas');

-- Sample Foods
INSERT INTO foods (name, category_id, calories, protein, carbs, fat, fiber, sodium, sugar, glycemic_index, description, image_url) VALUES
-- Grains
('Brown Rice', 1, 216, 5, 45, 1.8, 3.5, 10, 0.7, 55, 'Whole grain rice with more fiber than white rice', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLQfw3seNrdYdFNJzgzIQnWUgCbA0r2D_RxQ&s'),
('Quinoa', 1, 222, 8, 39, 3.6, 5, 13, 1.6, 53, 'Protein-rich seed that is cooked and eaten like a grain','https://images.immediate.co.uk/production/volatile/sites/30/2022/05/Quinoa-707f5e8.png?resize=768,713'),
('White Rice', 1, 205, 4.3, 45, 0.4, 0.6, 1.6, 0.1, 73, 'Refined grain with less fiber than brown rice','https://i0.wp.com/www.cocoandash.com/wp-content/uploads/2021/05/IMG_0447.jpg?fit=2592%2C1728&ssl=1'),
('Whole Wheat Bread', 1, 247, 13, 41, 3.4, 6, 380, 6, 71, 'Bread made from whole wheat flour','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhvnmSPfI3Ch2ZqQsq_4f-sXkJGuOhmWe4YQ&s'),

-- Vegetables
('Broccoli', 2, 55, 3.7, 11, 0.6, 2.6, 33, 2.2, 15, 'Nutrient-rich green vegetable','https://www.simplyrecipes.com/thmb/pWjqxmRxs_He1V18ryJZSpZab0Q=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/__opt__aboutcom__coeus__resources__content_migration__simply_recipes__uploads__2006__01__steamed-broccoli-horiz-b-2000-9c966360d0ad47a29120d700906697d9.jpg'),
('Spinach', 2, 23, 2.9, 3.6, 0.4, 2.2, 79, 0.4, 15, 'Leafy green vegetable high in iron','https://www.thespruceeats.com/thmb/Wpdr8OgU89mQDImdVsH96i_-dd4=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/what-is-spinach-4783497-hero-07-4a4e988cb48b4973a258d1cc44909780.jpg'),

-- Protein Foods
('Salmon', 5, 208, 20, 0, 13, 0, 59, 0, 0, 'Fatty fish rich in omega-3 fatty acids','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTuFd7zlYdssGFg2XtBEJGJIiJ19plfD64xXA&s'),
('Chicken Breast', 5, 165, 31, 0, 3.6, 0, 74, 0, 0, 'Lean protein source','https://downshiftology.com/wp-content/uploads/2023/01/How-To-Make-Air-Fryer-Chicken-5.jpg'),
('Almonds', 5, 579, 21, 22, 50, 12.5, 1, 4.4, 0, 'Nutritious tree nuts high in healthy fats','https://i0.wp.com/post.healthline.com/wp-content/uploads/2023/02/Almonds-Table-Bowl-1296x728-Header.jpg?w=1155&h=1528'),

-- Dairy
('Greek Yogurt', 4, 59, 10, 3.6, 0.4, 0, 36, 3.2, 0, 'Thick, protein-rich yogurt with probiotics','https://www.liveeatlearn.com/wp-content/uploads/2024/08/how-to-make-homemade-greek-yogurt-25.jpg');

-- Food Recommendations
INSERT INTO food_recommendations (food_id, condition_id, recommendation_type, reason, scientific_evidence) VALUES
-- Diabetes
(1, 1, 'Recommended', 'Low glycemic index helps control blood sugar levels', 'Studies show low-GI foods help manage blood glucose levels.'),
(2, 1, 'Recommended', 'High in protein and fiber which helps with blood sugar control', 'Quinoa has a low glycemic index and high protein content.'),
(3, 1, 'Avoid', 'High glycemic index can cause blood sugar spikes', 'White rice has a high glycemic index compared to whole grains.'),

-- Heart Disease
(7, 3, 'Recommended', 'Omega-3 fatty acids help reduce inflammation and support heart health', 'EPA and DHA in salmon reduce cardiovascular risk factors.'),
(9, 3, 'Recommended', 'Healthy monounsaturated fats support heart health', 'Almonds contain heart-healthy fats and vitamin E.'),

-- High Cholesterol
(7, 5, 'Recommended', 'Omega-3s help lower triglycerides', 'Fish oil supplementation reduces triglyceride levels.'),
(9, 5, 'Recommended', 'Monounsaturated fats can help lower LDL cholesterol', 'Nuts have been shown to improve lipid profiles.');

-- Food Swaps
INSERT INTO food_swaps (original_food_id, better_food_id, reason, benefit_description, condition_id) VALUES
(3, 1, 'Brown rice has more fiber and nutrients than white rice', 'Higher fiber content helps with blood sugar control and digestion', 1),
(4, 2, 'Quinoa is a complete protein and has more nutrients than white bread', 'Provides all essential amino acids and more vitamins/minerals', NULL),
(8, 7, 'Salmon provides healthy omega-3s compared to chicken', 'Omega-3 fatty acids support heart and brain health', 3);

-- Nutritionists (matching your premium.php)
INSERT INTO nutritionists (name, email, password, specialization, qualifications, experience_years, hourly_rate, bio, average_rating, total_reviews, meeting_link) VALUES
('Dr. Aliya Hassan', 'aliya@nutricare.com', '$2y$10$hashedpassword', 'Diabetes & Weight Management', 'PhD in Nutrition, RD', 15, 3500, '10+ years experience helping patients manage blood sugar through nutrition.', 4.5, 142, 'https://meet.nutricare.com/aliya-hassan'),
('Dr. Abdullah Khan', 'abdullah@nutricare.com', '$2y$10$hashedpassword', 'Pediatric Nutrition', 'MS in Nutrition, RD', 8, 4000, 'Specializes in child nutrition from infancy to adolescence.', 5.0, 89, 'https://meet.nutricare.com/abdullah-khan'),
('Dr. Hadiyah Malik', 'hadiyah@nutricare.com', '$2y$10$hashedpassword', 'Sports Nutrition', 'MS in Exercise Science, RD', 10, 4500, 'Helps athletes optimize performance through tailored nutrition plans.', 4.0, 67, 'https://meet.nutricare.com/hadiyah-malik'),
('Dr. Ali Rehman', 'ali@nutricare.com', '$2y$10$hashedpassword', 'Gut Health & Digestion', 'MD in Gastroenterology, RD', 12, 3800, 'Specializes in digestive disorders and gut microbiome optimization.', 5.0, 112, 'https://meet.nutricare.com/ali-rehman'),
('Dr. Eman Javed', 'eman@nutricare.com', '$2y$10$hashedpassword', 'Plant-Based Nutrition', 'MS in Nutrition, RD', 7, 3200, 'Expert in vegetarian and vegan nutrition planning.', 4.0, 76, 'https://meet.nutricare.com/eman-javed'),
('Dr. Harris Ali', 'harris@nutricare.com', '$2y$10$hashedpassword', 'Geriatric Nutrition', 'PhD in Gerontology, RD', 20, 4200, 'Specializes in nutritional needs for older adults and seniors.', 4.5, 93, 'https://meet.nutricare.com/harris-ali');

-- Nutritionist Specialties
INSERT INTO nutritionist_specialties (nutritionist_id, condition_id) VALUES
(1, 1), (1, 4), -- Dr. Aliya Hassan: Diabetes & Obesity
(2, 1), (2, 3), -- Dr. Abdullah Khan: Diabetes & Heart Disease
(3, 4),         -- Dr. Hadiyah Malik: Obesity
(4, 1), (4, 2), (4, 3), -- Dr. Ali Rehman: Diabetes, Hypertension, Heart Disease
(5, 1), (5, 4), -- Dr. Eman Javed: Diabetes & Obesity
(6, 2), (6, 3); -- Dr. Harris Ali: Hypertension & Heart Disease

-- Nutritionist Availability
INSERT INTO nutritionist_availability (nutritionist_id, day_of_week, start_time, end_time) VALUES
-- Dr. Aliya Hassan
(1, 'Monday', '09:00:00', '17:00:00'),
(1, 'Wednesday', '09:00:00', '17:00:00'),
(1, 'Friday', '09:00:00', '17:00:00'),

-- Dr. Abdullah Khan
(2, 'Tuesday', '08:00:00', '16:00:00'),
(2, 'Thursday', '08:00:00', '16:00:00'),
(2, 'Saturday', '10:00:00', '14:00:00'),

-- Dr. Hadiyah Malik
(3, 'Monday', '10:00:00', '18:00:00'),
(3, 'Wednesday', '10:00:00', '18:00:00'),
(3, 'Friday', '10:00:00', '18:00:00'),

-- Dr. Ali Rehman
(4, 'Tuesday', '09:30:00', '17:30:00'),
(4, 'Thursday', '09:30:00', '17:30:00'),
(4, 'Saturday', '10:00:00', '14:00:00'),

-- Dr. Eman Javed
(5, 'Monday', '10:00:00', '16:00:00'),
(5, 'Wednesday', '10:00:00', '16:00:00'),
(5, 'Friday', '10:00:00', '16:00:00'),

-- Dr. Harris Ali
(6, 'Tuesday', '08:30:00', '16:30:00'),
(6, 'Thursday', '08:30:00', '16:30:00'),
(6, 'Saturday', '09:00:00', '13:00:00');

-- Nutritionist Unavailable Dates
INSERT INTO nutritionist_unavailable_dates (nutritionist_id, date, reason) VALUES
(1, '2023-07-15', 'Conference'),
(1, '2023-07-20', 'Vacation'),
(2, '2023-07-18', 'Training'),
(2, '2023-07-19', 'Training'),
(3, '2023-07-17', 'Personal'),
(3, '2023-07-21', 'Conference'),
(4, '2023-07-16', 'Holiday'),
(4, '2023-07-23', 'Holiday'),
(5, '2023-07-14', 'Workshop'),
(5, '2023-07-24', 'Workshop'),
(6, '2023-07-13', 'Medical Leave'),
(6, '2023-07-25', 'Medical Leave');

-- Exercise Types
INSERT INTO exercise_types (name, description, intensity, duration_minutes, calories_burned, video_url) VALUES
('Brisk Walking', 'Walking at a pace that raises your heart rate', 'Moderate', 30, 150, 'https://www.youtube.com/watch?v=wQrV75N2BrI'),
('Yoga', 'Gentle stretching and breathing exercises', 'Low', 45, 180, 'https://www.youtube.com/watch?v=kqmut7-RARw'),
('Swimming', 'Full-body low-impact exercise', 'Moderate', 30, 250, 'https://www.youtube.com/watch?v=Rr_CnIfr5u8'),
('Cycling', 'Low-impact cardio exercise', 'Moderate', 30, 300, 'https://m.youtube.com/watch?v=ZiGE3-L4vyg&t=2m23s'),
('Resistance Training', 'Strength exercises using body weight or equipment', 'High', 45, 350, 'https://www.youtube.com/watch?v=8YhyqGJZyKs&pp=0gcJCdgAo7VqN5tD');

-- Exercise Recommendations
INSERT INTO exercise_recommendations (exercise_id, condition_id, frequency, duration_suggestion, notes, benefits) VALUES
-- Diabetes
(1, 1, '5 times per week', '30-60 minutes', 'Monitor blood sugar before and after exercise', 'Helps improve insulin sensitivity'),
(2, 1, '3 times per week', '45-60 minutes', 'Focus on stress-reducing poses', 'Reduces stress which can affect blood sugar'),

-- Heart Disease
(1, 3, 'Daily', '30 minutes minimum', 'Maintain moderate pace', 'Helps lower blood pressure and improve circulation'),
(3, 3, '3 times per week', '30 minutes', 'Use comfortable swimming style', 'Improves cardiovascular health without joint stress'),

-- Obesity
(4, 4, '5 times per week', '45 minutes', 'Start with flat terrain', 'Effective for weight loss when combined with diet'),
(5, 4, '3 times per week', '30-45 minutes', 'Focus on full-body exercises', 'Builds muscle which increases metabolic rate');

-- FAQs
INSERT INTO faqs (question, answer, category, is_featured) VALUES
('How do I get started with NutriCare?', 'Simply create an account, complete your profile, and start exploring food recommendations based on your health needs.', 'General', TRUE),
('Is NutriCare suitable for children?', 'Yes! Enable Child Nutrition Mode in your profile to get age-appropriate recommendations for your child.', 'Features', TRUE),
('How often are the food recommendations updated?', 'Our database is continuously updated with the latest nutrition research and guidelines.', 'Food', FALSE),
('Can I consult with a nutritionist through NutriCare?', 'Yes, we offer premium consultations with certified nutritionists. Book a session through the Premium Consult page.', 'Premium', TRUE),
('What payment methods do you accept for consultations?', 'We accept credit cards, bank transfers, JazzCash, and EasyPaisa for premium consultations.', 'Premium', TRUE),
('How do food swaps help my health?', 'Food swaps suggest healthier alternatives that are better suited to your medical conditions, often with more nutrients and fewer negative effects.', 'Food', TRUE);
