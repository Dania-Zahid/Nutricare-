<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

// Check if food ID is provided
if (!isset($_GET['id'])) {
    header('Location: admin_foods.php');
    exit;
}

$food_id = (int)$_GET['id'];

// Get all food categories
$categories = $conn->query("SELECT * FROM food_categories ORDER BY name")->fetchAll();

// Fetch food data
$food = $conn->query("SELECT * FROM foods WHERE food_id = $food_id")->fetch();

if (!$food) {
    $_SESSION['error'] = "Food item not found";
    header('Location: admin_foods.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $calories = (float)$_POST['calories'];
        $protein = (float)$_POST['protein'];
        $carbs = (float)$_POST['carbs'];
        $fat = (float)$_POST['fat'];
        $fiber = (float)$_POST['fiber'];
        $sodium = (float)$_POST['sodium'];
        $sugar = (float)$_POST['sugar'];
        $glycemic_index = !empty($_POST['glycemic_index']) ? (int)$_POST['glycemic_index'] : null;
        $is_common_allergen = isset($_POST['is_common_allergen']) ? 1 : 0;

        // Update food
        $stmt = $conn->prepare("UPDATE foods SET name = ?, description = ?, category_id = ?, calories = ?, protein = ?, carbs = ?, fat = ?, fiber = ?, sodium = ?, sugar = ?, glycemic_index = ?, is_common_allergen = ? WHERE food_id = ?");
        $stmt->execute([$name, $description, $category_id, $calories, $protein, $carbs, $fat, $fiber, $sodium, $sugar, $glycemic_index, $is_common_allergen, $food_id]);
        
        $_SESSION['message'] = "Food item updated successfully";
        header('Location: admin_foods.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating food item: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCare - Edit Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      :root {
            --green-light: #E3F4E1;
            --green: #5FB65A;
            --green-dark: #3C8D37;
            --sidebar-width: 250px;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--green-dark);
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 10px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        
        .sidebar-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
         @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content, .navbar-admin {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>NutriCare Admin</h3>
        </div>
        
        <div class="sidebar-menu">
            <a href="admin_dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="admin_users.php"><i class="fas fa-users"></i> Users</a>
            <a href="admin_nutritionists.php"><i class="fas fa-user-md"></i> Nutritionists</a>
            <a href="admin_foods.php"><i class="fas fa-utensils"></i> Foods</a>
            <a href="admin_conditions.php"><i class="fas fa-heartbeat"></i> Medical Conditions</a>
            <a href="admin_allergens.php"><i class="fas fa-allergies"></i> Allergens</a>
            <a href="admin_consultations.php"><i class="fas fa-calendar-check"></i> Consultations</a>
            <a href="admin_faqs.php"><i class="fas fa-question-circle"></i> FAQs</a>
            <a href="admin_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar-admin">
        <div class="d-flex justify-content-between w-100">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <span class="text-muted">Welcome, Admin</span>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Food: <?php echo htmlspecialchars($food['name']); ?></h2>
            <a href="admin_foods.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Foods
            </a>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Food Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($food['name']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $food['category_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($food['description']); ?></textarea>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="calories" class="form-label">Calories</label>
                            <input type="number" class="form-control" id="calories" name="calories" min="0" step="0.01" value="<?php echo $food['calories']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="protein" class="form-label">Protein (g)</label>
                            <input type="number" class="form-control" id="protein" name="protein" min="0" step="0.01" value="<?php echo $food['protein']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="carbs" class="form-label">Carbs (g)</label>
                            <input type="number" class="form-control" id="carbs" name="carbs" min="0" step="0.01" value="<?php echo $food['carbs']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="fat" class="form-label">Fat (g)</label>
                            <input type="number" class="form-control" id="fat" name="fat" min="0" step="0.01" value="<?php echo $food['fat']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="fiber" class="form-label">Fiber (g)</label>
                            <input type="number" class="form-control" id="fiber" name="fiber" min="0" step="0.01" value="<?php echo $food['fiber']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="sodium" class="form-label">Sodium (mg)</label>
                            <input type="number" class="form-control" id="sodium" name="sodium" min="0" step="0.01" value="<?php echo $food['sodium']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="sugar" class="form-label">Sugar (g)</label>
                            <input type="number" class="form-control" id="sugar" name="sugar" min="0" step="0.01" value="<?php echo $food['sugar']; ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="glycemic_index" class="form-label">Glycemic Index</label>
                            <input type="number" class="form-control" id="glycemic_index" name="glycemic_index" min="0" max="100" value="<?php echo $food['glycemic_index']; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_common_allergen" name="is_common_allergen" <?php echo $food['is_common_allergen'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="is_common_allergen">
                                Common Allergen
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Food
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>