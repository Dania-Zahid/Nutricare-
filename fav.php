<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NutriCare - Favorites</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>


<?php require 'Partials/nav.php';?>
<?php require 'Partials/head.php';?>

<style>
    :root {
      --green: #5FB65A;
      --green-dark: #3C8D37;
      --green-light: #E3F4E1;
      --gray-700: #4B5563;
      --gray-600: #6B7280;
      --gray-200: #F1F0FB;
      --border-radius: 0.75rem;
      --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f9fafb;
      margin: 0;
      padding: 2rem;
      color: var(--gray-700);
    }

    h2 {
      font-size: 1.75rem;
      margin-bottom: 1rem;
      color: var(--green-dark);
    }

    .section {
      margin-bottom: 3rem;
    }

    .favorites-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .card {
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--green-light);
      padding: 1rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: box-shadow 0.2s;
    }

    .card:hover {
      box-shadow: var(--shadow-md);
    }

    .card h3 {
      margin: 0 0 0.5rem;
      font-size: 1.1rem;
      color: var(--green-dark);
    }

    .card p {
      font-size: 0.9rem;
      color: var(--gray-600);
      margin-bottom: 1rem;
    }

    .card-buttons {
      display: flex;
      justify-content: space-between;
      gap: 0.5rem;
    }

    .btn {
      flex: 1;
      padding: 0.5rem 0.75rem;
      font-size: 0.85rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: background 0.2s;
    }

    .btn-remove {
      background-color: #fcdcdc;
      color: #b91c1c;
    }

    .btn-remove:hover {
      background-color: #f8b4b4;
    }

    .btn-tried {
      background-color: var(--green);
      color: white;
    }

    .btn-tried:hover {
      background-color: var(--green-dark);
    }
  </style>
</head>
<body>

  <div class="section">
    <h2>❤️ Recommended Foods</h2>
    <div class="favorites-grid">
      <div class="card">
        <h3>Oatmeal</h3>
        <p>Great for heart health and diabetes control.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
      <div class="card">
        <h3>Leafy Greens</h3>
        <p>Rich in iron and folate, great for anemia and hypertension.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>🔁 Food Swaps</h2>
    <div class="favorites-grid">
      <div class="card">
        <h3>Brown Rice</h3>
        <p>Swap for white rice – lower glycemic index.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
      <div class="card">
        <h3>Greek Yogurt</h3>
        <p>Swap for sour cream – more protein, less fat.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <h2>🧒 Child Nutrition</h2>
    <div class="favorites-grid">
      <div class="card">
        <h3>Mashed Bananas</h3>
        <p>Ideal for infants (6–12 months), gentle on digestion.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
      <div class="card">
        <h3>Boiled Eggs</h3>
        <p>Protein-rich food suitable for toddlers and young children.</p>
        <div class="card-buttons">
          <button class="btn btn-remove">Remove</button>
          <button class="btn btn-tried">Mark as Tried</button>
        </div>
      </div>
    </div>
  </div>

</body>

<?php require 'Partials/footer.php';?>
</html>