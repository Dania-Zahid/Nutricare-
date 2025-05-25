<?php
// Start session and include database connection
session_start();
require 'config.php';

// Initialize variables
$bookingSuccess = false;
$error = '';

// Process booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking'])) {
    try {
        // Get form data
        $user_id = $_SESSION['user_id'] ?? null;
        $nutritionist_name = $_POST['nutritionist_name'];
        $specialty = $_POST['specialty'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $health_notes = $_POST['health_notes'] ?? '';
        $consultation_fee = $_POST['consultation_fee'];
        $payment_method = $_POST['payment_method'];
        $payment_status = 'completed'; // Assuming payment is successful
        
        // Handle file upload
        $health_reports = null;
        if (isset($_FILES['health_reports']) && $_FILES['health_reports']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['health_reports'];
            
            // Validate file type and size
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            
            if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
                $uploadDir = 'uploads/health_reports/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = uniqid() . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $health_reports = $targetPath;
                }
            }
        }
        
        // Insert booking into database
        $stmt = $conn->prepare("INSERT INTO premium_bookings 
                              (user_id, nutritionist_name, specialty, appointment_date, appointment_time, 
                              health_notes, health_reports, consultation_fee, payment_method, payment_status, created_at) 
                              VALUES (:user_id, :nutritionist_name, :specialty, :appointment_date, :appointment_time, 
                              :health_notes, :health_reports, :consultation_fee, :payment_method, :payment_status, NOW())");
        
        $stmt->execute([
            ':user_id' => $user_id,
            ':nutritionist_name' => $nutritionist_name,
            ':specialty' => $specialty,
            ':appointment_date' => $appointment_date,
            ':appointment_time' => $appointment_time,
            ':health_notes' => $health_notes,
            ':health_reports' => $health_reports,
            ':consultation_fee' => $consultation_fee,
            ':payment_method' => $payment_method,
            ':payment_status' => $payment_status
        ]);
        
        $bookingSuccess = true;
        $bookingId = $conn->lastInsertId();
        
        // Store in session for confirmation display
        $_SESSION['last_booking'] = [
            'id' => $bookingId,
            'nutritionist_name' => $nutritionist_name,
            'specialty' => $specialty,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time,
            'consultation_fee' => $consultation_fee,
            'meeting_link' => $_POST['meeting_link']
        ];
        
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Get user's previous bookings if logged in
$previousBookings = [];
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM premium_bookings WHERE user_id = :user_id ORDER BY appointment_date DESC");
        $stmt->execute([':user_id' => $_SESSION['user_id']]);
        $previousBookings = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Error fetching bookings: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'Partials/nav.php'; ?>
  <?php require 'Partials/head.php'; ?>
  <style>
    :root {
      --green-light: #E3F4E1;
      --green: #5FB65A;
      --green-dark: #3C8D37;
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
    
    /* Premium Page Styles */
      /* Header */
    .premium-header {
      background: linear-gradient(135deg, #3C8D37 0%, #5FB65A 100%);
      color: white;
      padding: 1.5rem 1rem;
      text-align: center;
      position: relative;
      overflow: hidden;
      height: 180px; 
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(63, 141, 55, 0.2);
    }

    
    .premium-header h1 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      position: relative;
      z-index: 2;
      text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .premium-header p {
      font-size: 1rem;
      opacity: 0.9;
      position: relative;
      z-index: 2;
      max-width: 600px;
      margin: 0 auto;
    }

    
    /* Section Title Adjustments */
    .section-header {
      margin-top: 2.5rem; /* Increased spacing below banner */
      margin-bottom: 1.5rem;
    }

    .section-title {
      color: #3a7a36; /* Darker green for better contrast */
      font-size: 1.5rem;
      position: relative;
      display: inline-block;
    }

    .section-title:after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 50px;
      height: 3px;
      background: #5FB65A;
      border-radius: 3px;
    }

    .nutritionist-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
      padding: 2rem 1rem;
    }

    .nutritionist-card {
      background: white;
      border-radius: 0.75rem;
      box-shadow: var(--shadow-md);
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .nutritionist-card:hover {
      transform: translateY(-5px);
    }

    .nutritionist-photo {
      height: 200px;
      background-size:cover;
      background-position: center;
      
    }

    .nutri-1{
        width: 300px;
        height: 300px;
    }

    .nutri-2{
        width: 500px;
        height: 300px;
    }

    .nutri-3{
        width: 500px;
        height: 300px;
    }

    .nutritionist-info {
      padding: 1.5rem;
    }

    .nutritionist-specialty {
      display: inline-block;
      background: var(--green-light);
      color: var(--green-dark);
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      margin-bottom: 0.5rem;
    }

    .nutritionist-rating {
      color: #FFC107;
      margin: 0.5rem 0;
    }

    .availability-badge {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      font-size: 0.875rem;
    }

    .availability-online {
      color: var(--green);
    }

    .availability-offline {
      color: var(--gray-600);
    }

    .booking-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 100;
      align-items: center;
      justify-content: center;
    }

    .modal-content {
      background: white;
      border-radius: 0.75rem;
      width: 90%;
      max-width: 600px;
      max-height: 90vh;
      overflow-y: auto;
    }

    .time-slot-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 0.5rem;
      margin: 1rem 0;
    }

    .time-slot {
      padding: 0.5rem;
      border: 1px solid var(--green-light);
      border-radius: 0.25rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .time-slot:hover {
      background: var(--green-light);
    }

    .time-slot.selected {
      background: var(--green);
      color: white;
      border-color: var(--green);
    }

    .time-slot.unavailable {
      opacity: 0.5;
      cursor: not-allowed;
      text-decoration: line-through;
    }

    .session-history {
      background: var(--gray-200);
      padding: 2rem 1rem;
    }

    .session-card {
      background: white;
      border-radius: 0.75rem;
      padding: 1rem;
      margin-bottom: 1rem;
      box-shadow: var(--shadow-md);
    }

    .upload-health {
      margin-top: 1rem;
      border-top: 1px dashed var(--gray-600);
      padding-top: 1rem;
    }

     /* Date Picker Styles */
    input[type="date"]:disabled {
      background-color: #f0f0f0;
      color: #999;
    }
    
    .payment-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 100;
    align-items: center;
    justify-content: center;
  }
  
  #paymentSummary p {
    margin-bottom: 0.5rem;
  }
  
  #paymentSummary p:last-child {
    margin-bottom: 0;
    font-weight: 600;
    color: var(--green-dark);
  }

    /* Confirmation Modal */
    .confirmation-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 100;
      align-items: center;
      justify-content: center;
    }
    
    .confirmation-content {
      background: white;
      border-radius: 0.75rem;
      width: 90%;
      max-width: 500px;
      padding: 2rem;
      text-align: center;
    }
    
    .confirmation-icon {
      font-size: 3rem;
      color: var(--green);
      margin-bottom: 1rem;
    }
    
    .meeting-link {
      display: inline-block;
      margin-top: 1rem;
      color: var(--green);
      text-decoration: underline;
    }
    
    /* Upload feedback */
    .upload-feedback {
      font-size: 0.875rem;
      color: var(--green-dark);
      margin-top: 0.5rem;
      display: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .time-slot-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    
.has-error {
  border-color: #f87171 !important;
}

.error-message {
  color: #ef4444;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

/* Make the date picker show validation state */
input:invalid {
  border-color: #f87171;
}

  </style>
</head>
<body>
   
  <!-- Premium Consultation Content -->
  <main>
    <?php if ($bookingSuccess): ?>
      <div class="confirmation-modal" style="display: flex;">
        <div class="confirmation-content">
          <div class="confirmation-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <h3>Appointment Confirmed!</h3>
          <div style="text-align: left; margin: 1.5rem 0;">
            <p><strong>Nutritionist:</strong> <?= htmlspecialchars($_SESSION['last_booking']['nutritionist_name']) ?></p>
            <p><strong>Date:</strong> <?= date('l, F j, Y', strtotime($_SESSION['last_booking']['appointment_date'])) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($_SESSION['last_booking']['appointment_time']) ?></p>
            <p><strong>Consultation Fee:</strong> PKR <?= number_format($_SESSION['last_booking']['consultation_fee'], 2) ?></p>
          </div>
          <p>You'll receive a confirmation email with all the details.</p>
          <a href="<?= htmlspecialchars($_SESSION['last_booking']['meeting_link']) ?>" class="meeting-link" target="_blank">Join Meeting</a>
          <button class="btn btn-primary" style="margin-top: 1.5rem;" onclick="document.querySelector('.confirmation-modal').style.display = 'none'">
            Close
          </button>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert alert-danger" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <section class="premium-header">
      <h1>Premium Nutrition Consultations</h1>
      <p>Connect 1-on-1 with certified nutritionists tailored to your health goals</p>
    </section>

    <!-- Nutritionist Profiles -->
    <section class="container">
      <div class="section-header">
        <h2 class="section-title">Available Nutritionists</h2>
        <h3> Select a specialist and book your session</h3>
      </div>
      
      <div class="nutritionist-grid">
        <!-- Nutritionist 1 -->
        <div class="nutritionist-card">
          <div class="nutritionist-photo" >
             <img src="Images/doc3.jpeg" class="nutri-1" >
          </div>
          <div class="nutritionist-info">
            <span class="nutritionist-specialty">Diabetes & Weight Management</span>
            <h3>Dr. Aliya Hassan</h3>
            <div class="nutritionist-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span>(142 reviews)</span>
            </div>
            <p>10+ years experience helping patients manage blood sugar through nutrition.</p>
            <div class="availability-badge availability-online">
              <i class="fas fa-circle"></i>
              <span>Available today</span>
            </div>
            <button class="btn btn-primary book-btn" data-nutritionist="Dr. Aliya Hassan" data-specialty="Diabetes & Weight Management" style="margin-top: 1rem;">
              Book Session
            </button>
          </div>
        </div>

        <!-- Nutritionist 2 -->
        <div class="nutritionist-card">
          <div class="nutritionist-photo" >
             <img src="Images/doc6.jpeg" class="nutri-2" >
          </div>
          <div class="nutritionist-info">
            <span class="nutritionist-specialty">Pediatric Nutrition</span>
            <h3>Dr. Abdullah Khan</h3>
            <div class="nutritionist-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <span>(89 reviews)</span>
            </div>
            <p>Specializes in child nutrition from infancy to adolescence.</p>
            <div class="availability-badge availability-online">
              <i class="fas fa-circle"></i>
              <span>Available tomorrow</span>
            </div>
            <button class="btn btn-primary book-btn" data-nutritionist="Dr. Abdullah Khan" data-specialty="Pediatric Nutrition" style="margin-top: 1rem;">
              Book Session
            </button>
          </div>
        </div>

        <!-- Nutritionist 3 -->
        <div class="nutritionist-card">
          <div class="nutritionist-photo" >
             <img src="Images/doc2.jpeg" class="nutri-3" >
          </div>
          <div class="nutritionist-info">
            <span class="nutritionist-specialty">Sports Nutrition</span>
            <h3>Dr.Hadiyah Malik</h3>
            <div class="nutritionist-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="far fa-star"></i>
              <span>(67 reviews)</span>
            </div>
            <p>Helps athletes optimize performance through tailored nutrition plans.</p>
            <div class="availability-badge availability-offline">
              <i class="fas fa-circle"></i>
              <span>Available next week</span>
            </div>
            <button class="btn btn-primary book-btn" data-nutritionist="Dr.Hadiyah Malik" data-specialty="Sports Nutrition" style="margin-top: 1rem;">
              Book Session
            </button>
          </div>
        </div>
        
      <!-- Nutritionist 4 -->
<div class="nutritionist-card">
  <div class="nutritionist-photo">
    <img src="Images/doc4.jpeg" class="nutri-1">
  </div>
  <div class="nutritionist-info">
    <span class="nutritionist-specialty">Gut Health & Digestion</span>
    <h3>Dr. Ali Rehman</h3>
    <div class="nutritionist-rating">
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <span>(112 reviews)</span>
    </div>
    <p>Specializes in digestive disorders and gut microbiome optimization.</p>
    <div class="availability-badge availability-online">
      <i class="fas fa-circle"></i>
      <span>Available today</span>
    </div>
    <button class="btn btn-primary book-btn" data-nutritionist="Dr. Ali Rehman" data-specialty="Gut Health & Digestion" style="margin-top: 1rem;">
      Book Session
    </button>
  </div>
</div>

<!-- Nutritionist 5 -->
<div class="nutritionist-card">
  <div class="nutritionist-photo">
    <img src="Images/doc7.jpeg" class="nutri-1">
  </div>
  <div class="nutritionist-info">
    <span class="nutritionist-specialty">Plant-Based Nutrition</span>
    <h3>Dr. Eman Javed</h3>
    <div class="nutritionist-rating">
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="far fa-star"></i>
      <span>(76 reviews)</span>
    </div>
    <p>Expert in vegetarian and vegan nutrition planning.</p>
    <div class="availability-badge availability-offline">
      <i class="fas fa-circle"></i>
      <span>Available in 2 days</span>
    </div>
    <button class="btn btn-primary book-btn" data-nutritionist="Dr. Eman Javed" data-specialty="Plant-Based Nutrition" style="margin-top: 1rem;">
      Book Session
    </button>
  </div>
</div>

<!-- Nutritionist 6 -->
<div class="nutritionist-card">
  <div class="nutritionist-photo">
    <img src="Images/doc5.jpeg" class="nutri-1">
  </div>
  <div class="nutritionist-info">
    <span class="nutritionist-specialty">Geriatric Nutrition</span>
    <h3>Dr. Harris Ali</h3>
    <div class="nutritionist-rating">
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star"></i>
      <i class="fas fa-star-half-alt"></i>
      <span>(93 reviews)</span>
    </div>
    <p>Specializes in nutritional needs for older adults and seniors.</p>
    <div class="availability-badge availability-online">
      <i class="fas fa-circle"></i>
      <span>Available tomorrow</span>
    </div>
    <button class="btn btn-primary book-btn" data-nutritionist="Dr. Harris Ali" data-specialty="Geriatric Nutrition" style="margin-top: 1rem;">
      Book Session
    </button>
  </div>
</div>
      </div>
    </section>

    <!-- Booking Modal -->
    <div class="booking-modal" id="bookingModal">
      <div class="modal-content">
        <div class="modal-header" style="padding: 1rem; border-bottom: 1px solid var(--green-light); display: flex; justify-content: space-between; align-items: center;">
          <h3 id="modalNutritionistName">Book Session</h3>
          <button id="closeModal" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <div class="modal-body" style="padding: 1rem 1.5rem;">
          <form id="bookingForm" method="POST" action="premium.php" enctype="multipart/form-data">
            <input type="hidden" id="nutritionistName" name="nutritionist_name">
            <input type="hidden" id="nutritionistSpecialty" name="specialty">
            <input type="hidden" id="meetingLink" name="meeting_link">
            <input type="hidden" id="consultationFee" name="consultation_fee">
            
            <p id="modalSpecialty" style="color: var(--gray-600); margin-bottom: 1rem;"></p>
            
            <h4 style="margin-bottom: 0.5rem;">Select Date</h4>
            <input type="date" id="sessionDate" name="appointment_date" class="form-control" style="width: 100%; padding: 0.5rem; border: 1px solid var(--green-light); border-radius: 0.25rem; margin-bottom: 1rem;" required>
            
            <h4 style="margin-bottom: 0.5rem;">Available Time Slots</h4>
            <div class="time-slot-grid" id="timeSlots"></div>
            <input type="hidden" id="selectedTimeSlot" name="appointment_time" required>
            
            <div class="upload-health">
              <h4 style="margin-bottom: 0.5rem;">Additional Information</h4>
              <textarea id="healthNotes" name="health_notes" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid var(--green-light); border-radius: 0.25rem; margin-bottom: 1rem;" placeholder="Any health concerns or questions for the nutritionist?"></textarea>
              <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem;">
                  <input type="file" id="healthDocuments" name="health_reports" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                  <span class="btn btn-outline" style="display: inline-block; cursor: pointer;">
                    <i class="fas fa-upload" style="margin-right: 0.5rem;"></i>
                    Upload Health Reports
                  </span>
                </label>
                <small style="color: var(--gray-600);">Max. 5MB (PDF, JPG, PNG)</small>
                <div class="upload-feedback"></div>
              </div>
            </div>
            
            <div id="paymentMethodSection" style="margin-bottom: 1rem; display: none;">
              <h4 style="margin-bottom: 0.5rem;">Payment Method</h4>
              <select id="paymentMethod" name="payment_method" class="form-control" required>
                <option value="">Select payment method</option>
                <option value="credit_card">Credit/Debit Card</option>
                <option value="jazzcash">JazzCash</option>
                <option value="easypaisa">EasyPaisa</option>
                <option value="bank_transfer">Bank Transfer</option>
              </select>
            </div>
            
            <button type="submit" id="confirmBooking" name="confirm_booking" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
              Confirm Booking
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Session History -->
    <section class="session-history">
      <div class="container">
        <h2 class="section-title">Your Previous Sessions</h2>
        <p class="section-description">Review past consultations and feedback</p>
        
        <?php if (empty($previousBookings)): ?>
          <div class="session-card">
            <p>You don't have any previous sessions yet.</p>
          </div>
        <?php else: ?>
          <?php foreach ($previousBookings as $booking): ?>
            <div class="session-card">
              <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <h4><?= htmlspecialchars($booking['nutritionist_name']) ?></h4>
                <span style="color: var(--gray-600); font-size: 0.875rem;">
                  <?= date('M j, Y', strtotime($booking['appointment_date'])) ?>
                </span>
              </div>
              <p style="color: var(--gray-600); margin-bottom: 0.5rem;"><?= htmlspecialchars($booking['specialty']) ?></p>
              <div class="nutritionist-rating">
                <?php
                // Display rating (assuming you have a rating field in your database)
                $rating = $booking['rating'] ?? 4;
                $fullStars = floor($rating);
                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                
                for ($i = 0; $i < $fullStars; $i++): ?>
                  <i class="fas fa-star"></i>
                <?php endfor; ?>
                
                <?php if ($hasHalfStar): ?>
                  <i class="fas fa-star-half-alt"></i>
                <?php endif; ?>
                
                <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                  <i class="far fa-star"></i>
                <?php endfor; ?>
              </div>
              <?php if (!empty($booking['health_notes'])): ?>
                <p style="margin-top: 0.5rem;"><?= htmlspecialchars($booking['health_notes']) ?></p>
              <?php endif; ?>
              <?php if (!empty($booking['health_reports'])): ?>
                <p style="margin-top: 0.5rem;">
                  <a href="<?= htmlspecialchars($booking['health_reports']) ?>" target="_blank" style="color: var(--green);">
                    <i class="fas fa-file-alt"></i> View Health Report
                  </a>
                </p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Feather Icons
      feather.replace();
      
      // Set current year in footer
      document.getElementById('current-year').textContent = new Date().getFullYear();
      
      // ======================
      // MOBILE MENU TOGGLE
      // ======================
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
      
      // ======================
      // BOOKING SYSTEM
      // ======================
      
      // DOM Elements
      const bookingModal = document.getElementById('bookingModal');
      const bookButtons = document.querySelectorAll('.book-btn');
      const closeModal = document.getElementById('closeModal');
      const modalNutritionistName = document.getElementById('modalNutritionistName');
      const modalSpecialty = document.getElementById('modalSpecialty');
      const timeSlotsContainer = document.getElementById('timeSlots');
      const sessionDate = document.getElementById('sessionDate');
      const healthDocuments = document.getElementById('healthDocuments');
      const confirmBookingBtn = document.getElementById('confirmBooking');
      const nutritionistNameInput = document.getElementById('nutritionistName');
      const nutritionistSpecialtyInput = document.getElementById('nutritionistSpecialty');
      const meetingLinkInput = document.getElementById('meetingLink');
      const consultationFeeInput = document.getElementById('consultationFee');
      const selectedTimeSlotInput = document.getElementById('selectedTimeSlot');
      const paymentMethodSection = document.getElementById('paymentMethodSection');
      
      // Sample Data
      const availableSlots = {
        'Dr. Aliya Hassan': ['09:00 AM', '10:30 AM', '02:00 PM', '03:30 PM', '05:00 PM'],
        'Dr. Abdullah Khan': ['08:00 AM', '11:00 AM', '04:00 PM'],
        'Dr.Hadiyah Malik': ['10:00 AM', '01:30 PM', '03:00 PM', '06:00 PM'],
        'Dr. Ali Rehman': ['09:30 AM', '11:30 AM', '02:30 PM', '04:30 PM'],
        'Dr. Eman Javed': ['10:00 AM', '12:00 PM', '03:00 PM', '05:00 PM'],
        'Dr. Harris Ali': ['08:30 AM', '01:00 PM', '04:00 PM', '06:30 PM']
      };

      const nutritionistAvailability = {
        'Dr. Aliya Hassan': {
          unavailableDates: ['2023-07-15', '2023-07-20', '2023-07-22'],
          meetingLink: 'https://meet.nutricare.com/aliya-hassan',
          fee: 3500
        },
        'Dr. Abdullah Khan': {
          unavailableDates: ['2023-07-18', '2023-07-19'],
          meetingLink: 'https://meet.nutricare.com/abdullah-khan',
          fee: 4000
        },
        'Dr.Hadiyah Malik': {
          unavailableDates: ['2023-07-17', '2023-07-21'],
          meetingLink: 'https://meet.nutricare.com/hadiyah-malik',
          fee: 4500
        },
        'Dr. Ali Rehman': {
          unavailableDates: ['2023-07-16', '2023-07-23'],
          meetingLink: 'https://meet.nutricare.com/ali-rehman',
          fee: 3800
        },
        'Dr. Eman Javed': {
          unavailableDates: ['2023-07-14', '2023-07-24'],
          meetingLink: 'https://meet.nutricare.com/eman-javed',
          fee: 3200
        },
        'Dr. Harris Ali': {
          unavailableDates: ['2023-07-13', '2023-07-25'],
          meetingLink: 'https://meet.nutricare.com/harris-ali',
          fee: 3600
        }
      };

      let currentNutritionist = '';
      
      // ======================
      // FILE UPLOAD HANDLING
      // ======================
      const uploadFeedback = document.querySelector('.upload-feedback');
      
      healthDocuments.addEventListener('change', function() {
        if (this.files.length > 0) {
          const file = this.files[0];
          
          // Validate file size (5MB limit)
          if (file.size > 5 * 1024 * 1024) {
            uploadFeedback.textContent = 'File too large (max 5MB)';
            uploadFeedback.style.color = 'red';
            this.value = ''; // Clear the invalid file
          } else {
            uploadFeedback.textContent = `File ready: ${file.name}`;
            uploadFeedback.style.color = 'var(--green-dark)';
          }
          uploadFeedback.style.display = 'block';
        }
      });
      
      // ======================
      // DATE PICKER LOGIC
      // ======================
      function setupDatePicker(nutritionist) {
        currentNutritionist = nutritionist;
        const unavailableDates = nutritionistAvailability[nutritionist].unavailableDates;
        
        // Set min date to today
        const today = new Date().toISOString().split('T')[0];
        sessionDate.setAttribute('min', today);
        
        // Reset date picker
        sessionDate.value = '';
        timeSlotsContainer.innerHTML = '';
        selectedTimeSlotInput.value = '';
        
        // Set nutritionist data in hidden inputs
        nutritionistNameInput.value = nutritionist;
        nutritionistSpecialtyInput.value = document.querySelector(`.book-btn[data-nutritionist="${nutritionist}"]`).getAttribute('data-specialty');
        meetingLinkInput.value = nutritionistAvailability[nutritionist].meetingLink;
        consultationFeeInput.value = nutritionistAvailability[nutritionist].fee;
      }
      
      // Handle date selection changes
      sessionDate.addEventListener('change', function() {
        if (!currentNutritionist) return;
        
        // Clear previous time slots
        timeSlotsContainer.innerHTML = '';
        selectedTimeSlotInput.value = '';
        
        // Get day of week (0-6, Sunday-Saturday)
        const selectedDate = new Date(this.value);
        const dayOfWeek = selectedDate.getDay();
        
        // Generate time slots based on day of week
        let availableSlotsForDay = [];
        
        if (dayOfWeek === 0 || dayOfWeek === 6) {
          // Weekend - limited slots
          availableSlotsForDay = ['10:00 AM', '02:00 PM'];
        } else {
          // Weekday - normal slots
          availableSlotsForDay = availableSlots[currentNutritionist];
        }
        
        // Populate time slots
        availableSlotsForDay.forEach(slot => {
          const slotElement = document.createElement('div');
          slotElement.className = 'time-slot';
          slotElement.textContent = slot;
          slotElement.addEventListener('click', function() {
            document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            selectedTimeSlotInput.value = this.textContent;
          });
          timeSlotsContainer.appendChild(slotElement);
        });
      });
      
      // ======================
      // BOOKING MODAL HANDLERS
      // ======================
      
      // Open booking modal when a nutritionist is selected
      bookButtons.forEach(button => {
        button.addEventListener('click', function() {
          const nutritionist = this.getAttribute('data-nutritionist');
          const specialty = this.getAttribute('data-specialty');
          
          modalNutritionistName.textContent = `Book with ${nutritionist}`;
          modalSpecialty.textContent = specialty;
          
          // Setup date picker with nutritionist's availability
          setupDatePicker(nutritionist);
          
          bookingModal.style.display = 'flex';
          paymentMethodSection.style.display = 'none';
        });
      });
      
      // Close booking modal
      closeModal.addEventListener('click', function() {
        bookingModal.style.display = 'none';
      });
      
      // Close when clicking outside modal
      window.addEventListener('click', function(event) {
        if (event.target === bookingModal) {
          bookingModal.style.display = 'none';
        }
      });
      
      // ======================
      // FORM VALIDATION
      // ======================
      const bookingForm = document.getElementById('bookingForm');
      
      bookingForm.addEventListener('submit', function(e) {
        // Reset error states
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        document.querySelectorAll('.has-error').forEach(el => el.classList.remove('has-error'));
        
        let isValid = true;
        
        // Validate date
        if (!sessionDate.value) {
          showError(sessionDate, 'Please select a date');
          isValid = false;
        }
        
        // Validate time slot
        if (!selectedTimeSlotInput.value) {
          const timeSlotLabel = document.createElement('div');
          timeSlotLabel.className = 'error-message';
          timeSlotLabel.textContent = 'Please select a time slot';
          timeSlotLabel.style.color = 'red';
          timeSlotLabel.style.marginTop = '-0.5rem';
          timeSlotLabel.style.marginBottom = '1rem';
          timeSlotsContainer.parentNode.insertBefore(timeSlotLabel, timeSlotsContainer.nextSibling);
          isValid = false;
        }
        
        // Validate payment method (only show if user is logged in)
        <?php if (isset($_SESSION['user_id'])): ?>
          if (!document.getElementById('paymentMethod').value) {
            showError(document.getElementById('paymentMethod'), 'Please select a payment method');
            isValid = false;
          }
        <?php endif; ?>
        
        if (!isValid) {
          e.preventDefault();
          
          // Show payment method section if other fields are valid except payment method
          if (sessionDate.value && selectedTimeSlotInput.value) {
            paymentMethodSection.style.display = 'block';
          }
        } else {
          // All validations passed
          paymentMethodSection.style.display = 'block';
        }
      });
      
      // Helper function to show error messages
      function showError(inputElement, message) {
        inputElement.classList.add('has-error');
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.textContent = message;
        errorMessage.style.color = 'red';
        errorMessage.style.fontSize = '0.875rem';
        errorMessage.style.marginTop = '0.25rem';
        inputElement.parentNode.appendChild(errorMessage);
      }
      
      // Show payment method section when user selects a time slot
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('time-slot')) {
          <?php if (isset($_SESSION['user_id'])): ?>
            paymentMethodSection.style.display = 'block';
          <?php else: ?>
            // Redirect to login if user not logged in
            window.location.href = 'login.php?redirect=premium.php';
          <?php endif; ?>
        }
      });
    });
  </script>
</body>
<?php require 'Partials/footer.php'; ?>
</html>