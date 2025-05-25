<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'Partials/head.php';?>
  <?php require 'Partials/nav.php';?>
  <style>
    /* Reuse the existing color variables from home1.php */
    :root {
      --green-light: #E3F4E1;
      --green: #5FB65A;
      --green-dark: #3C8D37;
      --purple-light: #E5DEFF;
      --blue-light: #D3E4FD;
      --peach: #FDE1D3;
      --gray-100: #F9FAFB;
      --gray-200: #F1F0FB;
      --gray-300: #E5E7EB;
      --gray-400: #D1D5DB;
      --gray-500: #9CA3AF;
      --gray-600: #6B7280;
      --gray-700: #4B5563;
      --gray-800: #1F2937;
      --gray-900: #111827;
      --border-radius: 0.75rem;
      --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Child Nutrition Specific Styles */
    .child-nutrition-section {
      padding: 4rem 1rem;
      background-color: rgba(227, 244, 225, 0.3);
    }

    .age-group-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .age-group-title {
      font-size: 2rem;
      color: var(--green-dark);
      margin-bottom: 0.5rem;
    }

    .age-group-description {
      color: var(--gray-600);
      max-width: 800px;
      margin: 0 auto;
    }

    .nutrition-categories {
      display: grid;
      grid-template-columns: 1fr;
      gap: 2rem;
      margin-bottom: 3rem;
    }

    @media (min-width: 768px) {
      .nutrition-categories {
        grid-template-columns: 1fr 1fr;
      }
    }

    .category-card {
      background-color: white;
      border-radius: var(--border-radius);
      padding: 1.5rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid rgba(95, 182, 90, 0.15);
    }

    .category-title {
      font-size: 1.25rem;
      color: var(--green-dark);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
    }

    .category-title i {
      margin-right: 0.5rem;
      color: var(--green);
    }

    .food-list {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .food-card {
      display: flex;
      background-color: var(--gray-100);
      border-radius: calc(var(--border-radius) - 0.25rem);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .food-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
    }

    .food-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
    }

    .food-info {
      flex: 1;
      padding: 0.75rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .food-name {
      font-weight: 600;
      color: var(--gray-800);
      margin-bottom: 0.25rem;
    }

    .food-description {
      font-size: 0.875rem;
      color: var(--gray-600);
      margin-bottom: 0.5rem;
    }

    .food-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .food-benefits {
      font-size: 0.75rem;
      color: var(--green-dark);
      background-color: var(--green-light);
      padding: 0.25rem 0.5rem;
      border-radius: 9999px;
    }

    .btn-favorite {
      background: none;
      border: none;
      color: var(--gray-500);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-favorite:hover, .btn-favorite.active {
      color: var(--green);
    }

    .btn-favorite i {
      font-size: 1.25rem;
    }

    .nutrition-tips {
      background-color: white;
      border-radius: var(--border-radius);
      padding: 1.5rem;
      box-shadow: var(--shadow-sm);
      border: 1px solid rgba(211, 228, 253, 0.4);
      margin-top: 2rem;
    }

    .tips-title {
      font-size: 1.25rem;
      color: var(--gray-800);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
    }

    .tips-title i {
      margin-right: 0.5rem;
      color: var(--green);
    }

    .tips-list {
      list-style-type: none;
      padding-left: 0;
    }

    .tips-list li {
      padding: 0.5rem 0;
      border-bottom: 1px solid var(--gray-200);
      display: flex;
    }

    .tips-list li:last-child {
      border-bottom: none;
    }

    .tips-list li i {
      color: var(--green);
      margin-right: 0.5rem;
      flex-shrink: 0;
      margin-top: 0.25rem;
    }

    .not-enabled-message {
      text-align: center;
      padding: 4rem 1rem;
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-sm);
      max-width: 800px;
      margin: 0 auto;
    }

    .not-enabled-message i {
      font-size: 3rem;
      color: var(--gray-400);
      margin-bottom: 1rem;
    }

    .not-enabled-message h2 {
      color: var(--gray-700);
      margin-bottom: 1rem;
    }

    .not-enabled-message p {
      color: var(--gray-600);
      margin-bottom: 1.5rem;
    }

    .btn-enable {
      background-color: var(--green);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: var(--border-radius);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-enable:hover {
      background-color: var(--green-dark);
    }
  </style>
</head>
<body>
  <main>
    <!-- Child Nutrition Section -->
    <section class="child-nutrition-section">
      <div class="container">
        <!-- This would be dynamic based on user's selected age group from profile -->
        <div class="age-group-header">
          <h1 class="age-group-title">Nutrition for Children (0-3 years)</h1>
          <p class="age-group-description">
            Proper nutrition during the first 3 years is crucial for growth and development. 
            Here are recommended foods and important nutritional guidelines for your little one.
          </p>
        </div>

        <!-- Nutrition Categories Grid -->
        <div class="nutrition-categories">
          <!-- Recommended Foods -->
          <div class="category-card">
            <h2 class="category-title">
              <i class="fas fa-thumbs-up"></i> Recommended Foods
            </h2>
            <div class="food-list">
              <!-- Food Item 1 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=327&q=80" 
                     alt="Breastmilk" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Breastmilk</h3>
                    <p class="food-description">Complete nutrition for infants 0-6 months</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">High in antibodies</span>
                    <button class="btn-favorite" title="Add to favorites">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Food Item 2 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" 
                     alt="Avocado" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Avocado</h3>
                    <p class="food-description">Rich in healthy fats for brain development</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">High in folate</span>
                    <button class="btn-favorite" title="Add to favorites">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Food Item 3 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1603569283847-aa295f0d016a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1169&q=80" 
                     alt="Sweet Potato" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Sweet Potato</h3>
                    <p class="food-description">Great source of vitamin A and fiber</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">Easy to digest</span>
                    <button class="btn-favorite active" title="Remove from favorites">
                      <i class="fas fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Foods to Avoid -->
          <div class="category-card">
            <h2 class="category-title">
              <i class="fas fa-ban"></i> Foods to Avoid
            </h2>
            <div class="food-list">
              <!-- Food Item 1 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" 
                     alt="Honey" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Honey</h3>
                    <p class="food-description">Risk of infant botulism</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">Avoid until 1 year</span>
                    <button class="btn-favorite" title="Add to avoid list">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Food Item 2 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" 
                     alt="Whole Nuts" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Whole Nuts</h3>
                    <p class="food-description">Choking hazard for young children</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">Choking risk</span>
                    <button class="btn-favorite" title="Add to avoid list">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Food Item 3 -->
              <div class="food-card">
                <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" 
                     alt="Cow's Milk" class="food-image">
                <div class="food-info">
                  <div>
                    <h3 class="food-name">Cow's Milk (as main drink)</h3>
                    <p class="food-description">Not suitable before 12 months</p>
                  </div>
                  <div class="food-actions">
                    <span class="food-benefits">Low in iron</span>
                    <button class="btn-favorite" title="Add to avoid list">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Nutrition Tips -->
        <div class="nutrition-tips">
          <h2 class="tips-title">
            <i class="fas fa-lightbulb"></i> Important Nutrition Tips
          </h2>
          <ul class="tips-list">
            <li>
              <i class="fas fa-check-circle"></i>
              <span>Exclusive breastfeeding recommended for first 6 months</span>
            </li>
            <li>
              <i class="fas fa-check-circle"></i>
              <span>Introduce iron-rich foods at 6 months (pureed meats, iron-fortified cereals)</span>
            </li>
            <li>
              <i class="fas fa-check-circle"></i>
              <span>Introduce one new food at a time, waiting 3-5 days to check for allergies</span>
            </li>
            <li>
              <i class="fas fa-check-circle"></i>
              <span>No added salt or sugar in baby foods</span>
            </li>
            <li>
              <i class="fas fa-check-circle"></i>
              <span>Ensure adequate vitamin D supplementation (400 IU/day)</span>
            </li>
          </ul>
        </div>

        <!-- This section would show if child nutrition is not enabled in profile -->
        <!-- <div class="not-enabled-message">
          <i class="fas fa-child"></i>
          <h2>Child Nutrition Not Enabled</h2>
          <p>To access child nutrition recommendations, please enable Child Nutrition Mode in your profile settings and select your child's age group.</p>
          <button class="btn-enable">Go to Profile Settings</button>
        </div> -->
      </div>
    </section>
  </main>

  <?php require 'Partials/footer.php';?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Favorite button functionality
      const favoriteButtons = document.querySelectorAll('.btn-favorite');
      
      favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
          this.classList.toggle('active');
          const icon = this.querySelector('i');
          
          if (this.classList.contains('active')) {
            icon.classList.remove('far', 'fa-heart');
            icon.classList.add('fas', 'fa-heart');
            // Here you would send an AJAX request to save to favorites
            console.log('Added to favorites');
          } else {
            icon.classList.remove('fas', 'fa-heart');
            icon.classList.add('far', 'fa-heart');
            // Here you would send an AJAX request to remove from favorites
            console.log('Removed from favorites');
          }
        });
      });

      // This would be dynamic based on user's profile setting
      // For now we're showing 0-3 years as an example
      // In a real implementation, you would fetch this from the backend
      // based on the age group selected in the user's profile
      
      // Example of how you might fetch data for different age groups
      function loadAgeGroupData(ageGroup) {
        console.log(`Loading data for age group: ${ageGroup}`);
        // This would be an AJAX call to your backend
        // $.ajax({
        //   url: `/api/child-nutrition?age_group=${ageGroup}`,
        //   method: 'GET',
        //   success: function(data) {
        //     // Update the UI with the received data
        //     updateNutritionPage(data);
        //   }
        // });
      }

      // Check if child nutrition is enabled (would come from backend)
      const childNutritionEnabled = true; // This would be dynamic
      const selectedAgeGroup = '0-3'; // This would come from user's profile

      if (!childNutritionEnabled) {
        // Show the "not enabled" message and hide the content
        document.querySelector('.age-group-header').style.display = 'none';
        document.querySelector('.nutrition-categories').style.display = 'none';
        document.querySelector('.nutrition-tips').style.display = 'none';
        document.querySelector('.not-enabled-message').style.display = 'block';
      } else {
        // Load data for the selected age group
        loadAgeGroupData(selectedAgeGroup);
      }
    });
  </script>
</body>
<?php require 'Partials/footer.php';?>
</html>