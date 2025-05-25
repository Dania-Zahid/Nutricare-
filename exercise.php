<!DOCTYPE html>
<html lang="en">
<head>
   <?php require 'Partials/nav.php';?>
<?php require 'Partials/head.php';?>
  <style>
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
  
  --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-display: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}


    .exercise-section {
      padding: 4rem 0;
      background-color: var(--green-light);
    }
    
    .exercise-filters {
      display: flex;
      gap: 1rem;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }
    
    .filter-btn {
      padding: 0.5rem 1rem;
      background-color: white;
      border: 1px solid var(--gray-300);
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: all 0.2s ease;
    }
    
    .filter-btn.active, .filter-btn:hover {
      background-color: var(--green);
      color: white;
      border-color: var(--green);
    }
    
    .exercise-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
    
    .exercise-card {
      background-color: white;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: transform 0.3s ease;
    }
    
    .exercise-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }
    
    .exercise-image {
      height: 200px;
      background-color: var(--gray-200);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gray-500);
    }
    
    .exercise-content {
      padding: 1.5rem;
    }
    
    .exercise-tags {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 0.75rem;
      flex-wrap: wrap;
    }
    
    .exercise-tag {
      background-color: var(--green-light);
      color: var(--green-dark);
      padding: 0.25rem 0.75rem;
      border-radius: 1rem;
      font-size: 0.75rem;
      font-weight: 500;
    }
    
    .exercise-duration {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--gray-600);
      margin-top: 1rem;
    }
    
    .routine-section {
      margin-top: 3rem;
      background-color: white;
      border-radius: var(--border-radius);
      padding: 2rem;
      box-shadow: var(--shadow-sm);
    }
    
    .routine-day {
      margin-bottom: 2rem;
    }
    
    .routine-exercise {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem;
      border-radius: var(--border-radius);
      transition: background-color 0.2s ease;
    }
    
    .routine-exercise:hover {
      background-color: var(--green-light);
    }
    
    .routine-exercise img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 0.5rem;
    }
    
    @media (min-width: 768px) {
      .exercise-grid {
        grid-template-columns: 1fr 1fr;
      }
    }
    
    @media (min-width: 1024px) {
      .exercise-grid {
        grid-template-columns: 1fr 1fr 1fr;
      }
    }
    
  </style>
</head>
<body>
  

  <main class="exercise-section">
    <div class="container">
      <h1 class="section-title">Exercise Suggestions</h1>
      <p class="section-description">
        Personalized workout recommendations based on your health profile and fitness level.
      </p>
      
      <!-- Condition Filters -->
      <div class="exercise-filters">
        <button class="filter-btn active">All Exercises</button>
        <button class="filter-btn">Diabetes</button>
        <button class="filter-btn">Hypertension</button>
        <button class="filter-btn">Heart Health</button>
        <button class="filter-btn">Weight Loss</button>
        <button class="filter-btn">Mobility</button>
      </div>
      
      <!-- Exercise Cards Grid -->
      <div class="exercise-grid">
        <!-- Exercise 1 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-walking" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Low Impact</span>
              <span class="exercise-tag">Cardio</span>
            </div>
            <h3>Brisk Walking</h3>
            <p>Gentle cardiovascular exercise that improves circulation and helps manage blood sugar levels. Perfect for beginners.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>30 minutes daily</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
        
        <!-- Exercise 2 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-hands" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Stretching</span>
              <span class="exercise-tag">Flexibility</span>
            </div>
            <h3>Chair Yoga</h3>
            <p>Modified yoga poses done while seated to improve flexibility and reduce joint stress. Ideal for limited mobility.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>15-20 minutes</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
        
        <!-- Exercise 3 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-water" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Low Impact</span>
              <span class="exercise-tag">Full Body</span>
            </div>
            <h3>Water Aerobics</h3>
            <p>Buoyancy reduces joint stress while providing resistance for muscle strengthening. Excellent for arthritis.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>45 minutes, 3x/week</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
        
        <!-- Exercise 4 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-dumbbell" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Strength</span>
              <span class="exercise-tag">Resistance</span>
            </div>
            <h3>Resistance Band Workout</h3>
            <p>Builds muscle strength without heavy weights. Adjustable resistance for all fitness levels.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>20 minutes, 2x/week</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
        
        <!-- Exercise 5 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-lungs" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Breathing</span>
              <span class="exercise-tag">Relaxation</span>
            </div>
            <h3>Diaphragmatic Breathing</h3>
            <p>Deep breathing techniques to reduce stress and improve oxygen flow. Beneficial for hypertension.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>10 minutes daily</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
        
        <!-- Exercise 6 -->
        <div class="exercise-card">
          <div class="exercise-image">
            <i class="fas fa-balance-scale" style="font-size: 3rem;"></i>
          </div>
          <div class="exercise-content">
            <div class="exercise-tags">
              <span class="exercise-tag">Balance</span>
              <span class="exercise-tag">Coordination</span>
            </div>
            <h3>Tai Chi</h3>
            <p>Slow, flowing movements improve balance and mental focus while being gentle on joints.</p>
            <div class="exercise-duration">
              <i data-feather="clock"></i>
              <span>30 minutes, 3x/week</span>
            </div>
            <button class="btn btn-outline" style="margin-top: 1rem;">
              <i data-feather="play"></i>
              Watch Video
            </button>
          </div>
        </div>
      </div>
      
      <!-- Weekly Routine Section -->
      <div class="routine-section">
        <h2 class="section-title">Suggested Weekly Routine</h2>
        <p class="section-description">
          Based on your profile, we recommend this balanced exercise plan:
        </p>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Monday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-walking"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Brisk Walking</h4>
              <p style="color: var(--gray-600);">30 minutes moderate pace</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Tuesday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-dumbbell"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Resistance Training</h4>
              <p style="color: var(--gray-600);">Upper body focus, 20 minutes</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Wednesday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-water"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Water Aerobics</h4>
              <p style="color: var(--gray-600);">45 minute class</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Thursday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-walking"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Brisk Walking</h4>
              <p style="color: var(--gray-600);">30 minutes with intervals</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Friday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-dumbbell"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Resistance Training</h4>
              <p style="color: var(--gray-600);">Lower body focus, 20 minutes</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Saturday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-balance-scale"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Tai Chi</h4>
              <p style="color: var(--gray-600);">30 minute session</p>
            </div>
          </div>
        </div>
        
        <div class="routine-day">
          <h3 style="margin-bottom: 1rem; color: var(--green-dark);">Sunday</h3>
          <div class="routine-exercise">
            <div class="exercise-image" style="width: 60px; height: 60px; border-radius: 0.5rem;">
              <i class="fas fa-lungs"></i>
            </div>
            <div>
              <h4 style="margin-bottom: 0.25rem;">Rest & Recovery</h4>
              <p style="color: var(--gray-600);">Gentle stretching and breathing</p>
            </div>
          </div>
        </div>
        
        <button class="btn btn-primary" style="margin-top: 2rem;">
          <i data-feather="download"></i>
          Download Routine
        </button>
      </div>
    </div>
  </main>


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      feather.replace();
      
      // Set current year in footer
      document.getElementById('current-year').textContent = new Date().getFullYear();
      
      // Mobile menu toggle
      const menuToggle = document.getElementById('menu-toggle');
      const mobileMenu = document.getElementById('mobile-menu');
      const menuIcon = document.getElementById('menu-icon');
      const closeIcon = document.getElementById('close-icon');
      
      menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        
        if (mobileMenu.classList.contains('active')) {
          menuIcon.style.display = 'none';
          closeIcon.style.display = 'block';
        } else {
          menuIcon.style.display = 'block';
          closeIcon.style.display = 'none';
        }
      });
      
      // Filter buttons functionality
      const filterButtons = document.querySelectorAll('.filter-btn');
      filterButtons.forEach(button => {
        button.addEventListener('click', () => {
          filterButtons.forEach(btn => btn.classList.remove('active'));
          button.classList.add('active');
          // In a real implementation, this would filter the exercises
        });
      });
      
      // Video buttons would open modal or link to videos
      const videoButtons = document.querySelectorAll('.btn-outline');
      videoButtons.forEach(button => {
        button.addEventListener('click', (e) => {
          e.preventDefault();
          // This would open a video player in a real implementation
          alert('This would open an exercise video in a real implementation');
        });
      });
    });
  </script>
</body>
<?php require 'Partials/footer.php';?>
</html>