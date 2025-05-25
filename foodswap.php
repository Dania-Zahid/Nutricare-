
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriCare Food Swap</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 2rem;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .header {
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }

        .header h1 {
            color: green;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }
        
        .header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #2a9d8f, #8ab17d);
            border-radius: 2px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .search-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-direction: column;
        }
        
        @media (min-width: 768px) {
            .search-container {
                flex-direction: row;
            }
        }

        .search-box {
            display: flex;
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #2a9d8f;
            box-shadow: 0 0 0 3px rgba(42, 157, 143, 0.2);
        }

        .search-button {
            background-color:green;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color:green;
        }

        .recent-searches {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .recent-search-tag {
            background-color: #e0f5f2;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .recent-search-tag:hover {
            background-color: #bae8e2;
        }

        .alternatives-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .alternative-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .alternative-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .swap-header {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .swap-title {
            display: flex;
            flex-direction: column;
        }

        .swap-arrows {
            font-size: 1.5rem;
            color: #2a9d8f;
            font-weight: bold;
        }

        .original-food {
            font-size: 1rem;
            color: #e76f51;
            text-decoration: line-through;
            margin-bottom: 0.3rem;
        }

        .alternative-food {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2a9d8f;
        }

        .alternative-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .alternative-info {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .benefits-list {
            margin: 1rem 0;
            flex: 1;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.8rem;
        }

        .benefit-icon {
            background-color: #e0f5f2;
            color: #2a9d8f;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            margin-right: 0.8rem;
            flex-shrink: 0;
        }

        .benefit-text {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.5;
        }

        .alternative-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.7rem 1.2rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #ddd;
            color: #666;
        }

        .btn-outline:hover {
            background-color: #f9f9f9;
            border-color: #ccc;
        }

        .btn-primary {
            background-color: #2a9d8f;
            color: white;
        }

        .btn-primary:hover {
            background-color: #248277;
        }
        
        .nutrition-badge {
            background-color: #f8f9fa;
            padding: 0.3rem 0.7rem;
            border-radius: 30px;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
            color: #666;
            border: 1px solid #eee;
        }

        .nutrition-badges {
            display: flex;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .alternatives-container {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .container {
                padding: 1.5rem;
                margin: 0 0.5rem;
            }
            
            body {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .alternative-actions {
                flex-direction: column;
                gap: 0.8rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .search-container {
                flex-direction: column;
            }
            
            .search-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- PHP includes for navigation and header -->
    <?php require 'Partials/head.php';?>
    <?php require 'Partials/nav.php';?>
    
    <div class="container">
        <div class="header">
            <h1>Food Swap Finder</h1>
            <p>Discover healthier alternatives to your favorite foods</p>
        </div>

        <div class="search-container">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Enter a food item (e.g., white rice, potato chips)" id="food-search">
            </div>
            <button class="search-button" id="search-button">Find Alternatives</button>
        </div>

        <div class="recent-searches">
            <span class="recent-search-tag">White rice</span>
            <span class="recent-search-tag">Ice cream</span>
            <span class="recent-search-tag">Potato chips</span>
            <span class="recent-search-tag">White bread</span>
        </div>

        <div class="alternatives-container">
            <!-- Alternative Card 1: Brown Rice -->
            <div class="alternative-card">
                <div class="swap-header">
                    <div class="swap-title">
                        <div class="original-food">White Rice</div>
                        <div class="alternative-food">Brown Rice</div>
                    </div>
                    <div class="swap-arrows">→</div>
                </div>
                <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Brown rice" class="alternative-image">
                <div class="alternative-info">
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Lower glycemic index - helps maintain steady blood sugar levels</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Higher in fiber which supports digestive health</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Contains more nutrients including vitamin B, magnesium and phosphorus</div>
                        </div>
                    </div>
                    
                    <div class="nutrition-badges">
                        <span class="nutrition-badge">High fiber</span>
                        <span class="nutrition-badge">Low GI</span>
                        <span class="nutrition-badge">Whole grain</span>
                    </div>
                    
                    <div class="alternative-actions">
                        <button class="btn btn-outline" id="favorite-btn-1">❤️ Add to Favorites</button>
                        <button class="btn btn-primary">ℹ️ Nutrition Info</button>
                    </div>
                </div>
            </div>

            <!-- Alternative Card 2: Quinoa -->
            <div class="alternative-card">
                <div class="swap-header">
                    <div class="swap-title">
                        <div class="original-food">White Rice</div>
                        <div class="alternative-food">Quinoa</div>
                    </div>
                    <div class="swap-arrows">→</div>
                </div>
                <img src="https://images.unsplash.com/photo-1612708308455-fe03a1e76aa4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Quinoa" class="alternative-image">
                <div class="alternative-info">
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Complete protein source containing all 9 essential amino acids</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Rich in antioxidants that help fight inflammation</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Contains higher amounts of iron and magnesium than white rice</div>
                        </div>
                    </div>
                    
                    <div class="nutrition-badges">
                        <span class="nutrition-badge">High protein</span>
                        <span class="nutrition-badge">Gluten-free</span>
                        <span class="nutrition-badge">Iron-rich</span>
                    </div>
                    
                    <div class="alternative-actions">
                        <button class="btn btn-outline" id="favorite-btn-2">❤️ Add to Favorites</button>
                        <button class="btn btn-primary">ℹ️ Nutrition Info</button>
                    </div>
                </div>
            </div>

            <!-- Alternative Card 3: Cauliflower Rice -->
            <div class="alternative-card">
                <div class="swap-header">
                    <div class="swap-title">
                        <div class="original-food">White Rice</div>
                        <div class="alternative-food">Cauliflower Rice</div>
                    </div>
                    <div class="swap-arrows">→</div>
                </div>
                <img src="https://images.unsplash.com/photo-1510627498534-cf7e9002facc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Cauliflower Rice" class="alternative-image">
                <div class="alternative-info">
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Significantly fewer calories and carbohydrates</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">High in vitamins C, K and folate</div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">✓</div>
                            <div class="benefit-text">Contains antioxidants that may reduce risk of heart disease</div>
                        </div>
                    </div>
                    
                    <div class="nutrition-badges">
                        <span class="nutrition-badge">Low-carb</span>
                        <span class="nutrition-badge">Vitamin-rich</span>
                        <span class="nutrition-badge">Keto-friendly</span>
                    </div>
                    
                    <div class="alternative-actions">
                        <button class="btn btn-outline" id="favorite-btn-3">❤️ Add to Favorites</button>
                        <button class="btn btn-primary">ℹ️ Nutrition Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PHP include for footer -->
    <?php require 'Partials/footer.php';?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('food-search');
            const searchButton = document.getElementById('search-button');
            
            searchButton.addEventListener('click', function() {
                const searchValue = searchInput.value.trim().toLowerCase();
                if (searchValue) {
                    // In a real app, this would trigger an API call
                    console.log('Searching for alternatives to:', searchValue);
                    // For demo purposes we're just showing the existing alternatives
                }
            });
            
            // Recent search tags functionality
            const recentSearchTags = document.querySelectorAll('.recent-search-tag');
            recentSearchTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    searchInput.value = this.textContent;
                    searchButton.click();
                });
            });
            
            // Add to favorites functionality
            const favoriteButtons = document.querySelectorAll('[id^="favorite-btn"]');
            favoriteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const currentText = this.textContent;
                    if (currentText.includes('Add to')) {
                        this.textContent = '✓ Added to Favorites';
                        this.style.backgroundColor = '#e6f7ff';
                        this.style.borderColor = '#91d5ff';
                        this.style.color = '#1890ff';
                    } else {
                        this.textContent = '❤️ Add to Favorites';
                        this.style.backgroundColor = 'transparent';
                        this.style.borderColor = '#ddd';
                        this.style.color = '#666';
                    }
                });
            });
        });
    </script>
</body>
</html>
