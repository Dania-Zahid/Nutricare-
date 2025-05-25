<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'Partials/head.php'; ?>
    <style>
        :root {
            --primary-green: #2a9d8f;
            --light-green: #8ab17d;
            --dark-green: #1a5d57;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #333333;
            --white: #ffffff;
            --red: #e76f51;
            --orange: #f4a261;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--light-gray);
            color: var(--dark-gray);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green));
        }

        .header {
            margin-bottom: 3rem;
            text-align: center;
            position: relative;
            padding-bottom: 1.5rem;
        }

        .header h1 {
            color: var(--primary-green);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
            letter-spacing: 1px;
        }

        .header h1::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green));
            border-radius: 2px;
        }

        .header p {
            color: var(--dark-gray);
            font-size: 1.1rem;
            max-width: 700px;
            margin: 1rem auto 0;
            line-height: 1.6;
        }

        /* Tabs styling */
        .tabs {
            display: flex;
            border-bottom: 1px solid var(--medium-gray);
            margin-bottom: 2.5rem;
            position: relative;
            flex-wrap: wrap;
            justify-content: center;
        }

        .tab {
            padding: 1rem 2rem;
            cursor: pointer;
            font-weight: 600;
            color: var(--dark-gray);
            position: relative;
            transition: all 0.3s ease;
            white-space: nowrap;
            user-select: none;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .tab.active {
            color: var(--primary-green);
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-green);
        }

        .tab:hover:not(.active) {
            color: var(--light-green);
        }

        /* Tab content */
        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Food cards grid */
        .foods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .food-card {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid rgba(42, 157, 143, 0.1);
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: rgba(42, 157, 143, 0.3);
        }

        .food-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .food-card:hover .food-image {
            transform: scale(1.03);
        }

        .food-info {
            padding: 1.5rem;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .food-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-gray);
        }

        .food-reason {
            color: var(--dark-gray);
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            flex-grow: 1;
            opacity: 0.9;
        }

        .food-buttons {
            display: flex;
            justify-content: space-between;
            gap: 0.8rem;
        }

        .btn {
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            flex: 1;
            justify-content: center;
            user-select: none;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--medium-gray);
            color: var(--dark-gray);
            flex: 1;
        }

        .btn-outline:hover {
            background-color: var(--light-gray);
            border-color: var(--primary-green);
            color: var(--primary-green);
        }

        /* Indicator colors for different tabs */
        .recommended-indicator {
            background-color: var(--light-green);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .avoid-indicator {
            background-color: var(--red);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .moderation-indicator {
            background-color: var(--orange);
            color: var(--white);
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Favorites section */
        #favorites-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        #no-favorites-message {
            grid-column: 1 / -1;
            text-align: center;
            color: var(--dark-gray);
            font-size: 1.1rem;
            padding: 2rem;
            opacity: 0.7;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            main {
                padding: 1rem;
            }
            
            .container {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 2.2rem;
            }

            .header p {
                font-size: 1rem;
            }

            .foods-grid, #favorites-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .tab {
                padding: 0.8rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.8rem;
            }

            .foods-grid, #favorites-container {
                grid-template-columns: 1fr;
                gap: 1.2rem;
            }

            .tabs {
                flex-wrap: wrap;
            }

            .tab {
                flex: 1 1 auto;
                text-align: center;
                padding: 0.8rem 0.5rem;
                font-size: 0.85rem;
            }

            .food-buttons {
                flex-direction: column;
                gap: 0.8rem;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php require 'Partials/nav.php'; ?>
    
    <main>
        <div class="container">
            <div class="header">
                <h1>Food Recommendations</h1>
                <p>Discover personalized food suggestions tailored to your health needs and preferences. Our recommendations are based on your health profile to help you make the best dietary choices.</p>
            </div>

            <div class="tabs" role="tablist" aria-label="Food recommendation sections">
                <div class="tab active" data-tab="recommended" role="tab" aria-selected="true" tabindex="0">Recommended</div>
                <div class="tab" data-tab="avoid" role="tab" aria-selected="false" tabindex="-1">To Avoid</div>
                <div class="tab" data-tab="moderation" role="tab" aria-selected="false" tabindex="-1">Moderation</div>
                <div class="tab favorites-tab" data-tab="favorites" role="tab" aria-selected="false" tabindex="-1">Your Favorites</div>
            </div>

            <!-- Recommended Foods Tab -->
            <div id="recommended" class="tab-content active" role="tabpanel" aria-hidden="false">
                <div class="foods-grid" id="recommended-grid">
                    <div class="food-card" data-id="salmon" data-name="Salmon" data-reason="Rich in omega-3 fatty acids that help reduce inflammation and support heart health. Great for your current cholesterol levels.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Salmon fillet" />
                        <div class="food-info">
                            <span class="recommended-indicator">Recommended</span>
                            <h3 class="food-name">Salmon</h3>
                            <p class="food-reason">Rich in omega-3 fatty acids that help reduce inflammation and support heart health. Great for your current cholesterol levels.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="spinach" data-name="Spinach" data-reason="High in iron, vitamin K and antioxidants. Supports blood health and provides nutrients essential for your condition.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1576045057995-568f588f82fb?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Spinach" />
                        <div class="food-info">
                            <span class="recommended-indicator">Recommended</span>
                            <h3 class="food-name">Spinach</h3>
                            <p class="food-reason">High in iron, vitamin K and antioxidants. Supports blood health and provides nutrients essential for your condition.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="blueberries" data-name="Blueberries" data-reason="Packed with antioxidants that help protect against cell damage. Low glycemic index makes them suitable for your blood sugar levels.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1596591606975-97ee5cef3a1e?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Blueberries" />
                        <div class="food-info">
                            <span class="recommended-indicator">Recommended</span>
                            <h3 class="food-name">Blueberries</h3>
                            <p class="food-reason">Packed with antioxidants that help protect against cell damage. Low glycemic index makes them suitable for your blood sugar levels.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Avoid Foods Tab -->
            <div id="avoid" class="tab-content" role="tabpanel" aria-hidden="true">
                <div class="foods-grid" id="avoid-grid">
                    <div class="food-card" data-id="processed-meats" data-name="Processed Meats" data-reason="High in sodium and preservatives that can increase blood pressure and inflammation. Not recommended for your cardiovascular health.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1555532530-6dd0a5ee1f50?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Processed meats" />
                        <div class="food-info">
                            <span class="avoid-indicator">Avoid</span>
                            <h3 class="food-name">Processed Meats</h3>
                            <p class="food-reason">High in sodium and preservatives that can increase blood pressure and inflammation. Not recommended for your cardiovascular health.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="sugary-drinks" data-name="Sugary Drinks" data-reason="High in added sugars that can negatively impact your blood sugar levels and contribute to weight gain.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1581006852262-e4307cf6283a?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Sugary drinks" />
                        <div class="food-info">
                            <span class="avoid-indicator">Avoid</span>
                            <h3 class="food-name">Sugary Drinks</h3>
                            <p class="food-reason">High in added sugars that can negatively impact your blood sugar levels and contribute to weight gain.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="white-bread" data-name="White Bread" data-reason="Contains refined carbohydrates that can spike blood sugar levels. Whole grain alternatives are better for your health profile.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1598373182133-52452f7691ef?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="White bread" />
                        <div class="food-info">
                            <span class="avoid-indicator">Avoid</span>
                            <h3 class="food-name">White Bread</h3>
                            <p class="food-reason">Contains refined carbohydrates that can spike blood sugar levels. Whole grain alternatives are better for your health profile.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Moderation Foods Tab -->
            <div id="moderation" class="tab-content" role="tabpanel" aria-hidden="true">
                <div class="foods-grid" id="moderation-grid">
                    <div class="food-card" data-id="dark-chocolate" data-name="Dark Chocolate" data-reason="Contains antioxidants that can benefit heart health, but also has sugar and fat. Enjoy in small amounts of 1-2 squares per day.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1549007994-cb92caebd54b?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Dark chocolate" />
                        <div class="food-info">
                            <span class="moderation-indicator">Moderation</span>
                            <h3 class="food-name">Dark Chocolate</h3>
                            <p class="food-reason">Contains antioxidants that can benefit heart health, but also has sugar and fat. Enjoy in small amounts of 1-2 squares per day.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="avocado" data-name="Avocado" data-reason="Rich in healthy fats and nutrients, but high in calories. Limit to 1/2 avocado per day to benefit without excess calorie intake.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1519162808019-7de1683fa2ad?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=1000&amp;q=80" alt="Avocado" />
                        <div class="food-info">
                            <span class="moderation-indicator">Moderation</span>
                            <h3 class="food-name">Avocado</h3>
                            <p class="food-reason">Rich in healthy fats and nutrients, but high in calories. Limit to 1/2 avocado per day to benefit without excess calorie intake.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>

                    <div class="food-card" data-id="sugary-foods" data-name="Sugary Foods" data-reason="Excess sugar can lead to weight gain, insulin resistance, and dental problems. Excess sugar can also affect your energy levels.">
                        <img class="food-image" src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Sugary Foods" />
                        <div class="food-info">
                            <span class="moderation-indicator">Moderation</span>
                            <h3 class="food-name">Sugary Foods</h3>
                            <p class="food-reason">Excess sugar can lead to weight gain, insulin resistance, and dental problems. Excess sugar can also affect your energy levels.</p>
                            <div class="food-buttons">
                                <button class="btn btn-outline btn-favorite">❤️ Add to Favorites</button>
                                <button class="btn btn-primary btn-nutrition">ℹ️ Nutrition Info</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Favorites Tab Content -->
            <div id="favorites" class="tab-content" role="tabpanel" aria-hidden="true">
                <div id="favorites-container" class="foods-grid" aria-live="polite" aria-atomic="true">
                    <p id="no-favorites-message">You have no favorite foods yet. Start adding some by clicking the ❤️ button on any food card!</p>
                </div>
            </div>
        </div>
    </main>

    <?php require 'Partials/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');
            const favoritesContainer = document.getElementById('favorites-container');
            const noFavMessage = document.getElementById('no-favorites-message');

            // Store favorites as Map: key food id, value cloned card element
            const favorites = new Map();

            // Keep track of last non-favorites tab
            let lastRecommendedTab = 'recommended';

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const tabId = tab.getAttribute('data-tab');

                    if (tabId !== 'favorites') {
                        lastRecommendedTab = tabId;
                    }

                    switchToTab(tabId);
                });

                tab.addEventListener('keydown', e => {
                    if(e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                        e.preventDefault();
                        const currentIndex = Array.from(tabs).indexOf(e.target);
                        let newIndex = e.key === 'ArrowRight' ? currentIndex + 1 : currentIndex -1;
                        if(newIndex < 0) newIndex = tabs.length - 1;
                        if(newIndex >= tabs.length) newIndex = 0;
                        tabs[newIndex].focus();
                    }
                    if(e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const tabId = e.target.getAttribute('data-tab');
                        if(tabId !== 'favorites') {
                            lastRecommendedTab = tabId;
                        }
                        switchToTab(tabId);
                    }
                });
            });

            function switchToTab(tabId) {
                tabs.forEach(t => {
                    t.classList.remove('active');
                    t.setAttribute('aria-selected', 'false');
                    t.setAttribute('tabindex', '-1');
                });
                tabContents.forEach(c => {
                    c.classList.remove('active');
                    c.setAttribute('aria-hidden', 'true');
                });

                const activeTab = document.querySelector(`.tab[data-tab="${tabId}"]`);
                const activeContent = document.getElementById(tabId);

                if (activeTab && activeContent) {
                    activeTab.classList.add('active');
                    activeTab.setAttribute('aria-selected', 'true');
                    activeTab.setAttribute('tabindex', '0');
                    activeTab.focus();

                    activeContent.classList.add('active');
                    activeContent.setAttribute('aria-hidden', 'false');
                }
            }

            // Create favorite card with remove button
            function createFavoriteCard(foodCard) {
                const clone = foodCard.cloneNode(true);

                const favBtn = clone.querySelector('.btn-favorite');
                const nutritionBtn = clone.querySelector('.btn-nutrition');

                // Change favorite button to 'Remove from Favorites' style
                favBtn.textContent = '❌ Remove from Favorites';
                favBtn.classList.remove('btn-outline');
                favBtn.classList.add('btn-remove');
                favBtn.style.backgroundColor = '#e76f51';
                favBtn.style.color = 'white';
                favBtn.style.border = 'none';
                favBtn.disabled = false;
                favBtn.style.cursor = 'pointer';

                // Remove previous event listeners by cloning button
                const newFavBtn = favBtn.cloneNode(true);
                favBtn.parentNode.replaceChild(newFavBtn, favBtn);

                newFavBtn.addEventListener('click', () => {
                    favorites.delete(foodCard.getAttribute('data-id'));
                    refreshFavorites();
                    updateAddFavoriteButton(foodCard, false);
                });

                nutritionBtn.addEventListener('click', () => {
                    const name = clone.getAttribute('data-name');
                    const reason = clone.getAttribute('data-reason');
                    alert(`Nutritional Breakdown for ${name}:\n\n${reason}`);
                });

                return clone;
            }

            // Update add favorite button on original card
            function updateAddFavoriteButton(foodCard, added) {
                const btn = foodCard.querySelector('.btn-favorite');
                if(added) {
                    btn.textContent = '✓ Added to Favorites';
                    btn.disabled = true;
                    btn.style.backgroundColor = '#8ab17d';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    btn.style.cursor = 'default';
                } else {
                    btn.textContent = '❤️ Add to Favorites';
                    btn.disabled = false;
                    btn.style.backgroundColor = 'transparent';
                    btn.style.color = '#666';
                    btn.style.border = '1px solid #ddd';
                    btn.style.cursor = 'pointer';
                }
            }

            // Refresh favorites container
            function refreshFavorites() {
                favoritesContainer.innerHTML = '';
                if (favorites.size === 0) {
                    favoritesContainer.appendChild(noFavMessage);
                    noFavMessage.style.display = 'block';
                } else {
                    noFavMessage.style.display = 'none';
                    favorites.forEach(foodCard => {
                        const favCard = createFavoriteCard(foodCard);
                        favoritesContainer.appendChild(favCard);
                    });
                }
            }

            // Initialize favorites buttons on all food cards
            function initFavoriteButtons() {
                const foodCards = document.querySelectorAll('.food-card');
                foodCards.forEach(card => {
                    const favBtn = card.querySelector('.btn-favorite');
                    const nutritionBtn = card.querySelector('.btn-nutrition');

                    // If already favorited, disable button style
                    if (favorites.has(card.getAttribute('data-id'))) {
                        updateAddFavoriteButton(card, true);
                    }

                    favBtn.addEventListener('click', () => {
                        const foodId = card.getAttribute('data-id');
                        if (!favorites.has(foodId)) {
                            favorites.set(foodId, card.cloneNode(true));
                            refreshFavorites();
                            updateAddFavoriteButton(card, true);
                        }
                    });

                    nutritionBtn.addEventListener('click', () => {
                        const name = card.getAttribute('data-name');
                        const reason = card.getAttribute('data-reason');
                        alert(`Nutritional Breakdown for ${name}:\n\n${reason}`);
                    });
                });
            }

            initFavoriteButtons();
            refreshFavorites();
        });
    </script>
</body>
</html>