<?php
// Include database connection
include 'config.php'; // Ensure this points to the correct path for your db.php file

// Pagination setup
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 16; // Products per page
$offset = ($page - 1) * $limit;

// Fetch products from the database with pagination
$sql = "SELECT id, product_name, category, image_url FROM products LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Fetch total number of products for pagination
$sql_count = "SELECT COUNT(*) AS total FROM products";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];
$total_pages = ceil($total_products / $limit);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/Navbar.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/shop.css">
    <script type="text/javascript" src="./script/index.js"></script>
</head>
<body>

<section class="header-nav">
    <div class="topnav">
        <div class="logo">
            <img src="./assets/images/logo.svg" alt="Logo" class="logo-img">
        </div>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="Shop.php">Shop</a>
            <a href="About.html">About</a>
            <a href="Contact.html">Contact</a>
        </div>
    </div>
</section>

<div class="hero">
    <img src="./assets/images/shop.svg" alt="Modern Sofa"/>
    <div class="video-text">
        <h1>Shop</h1>
    </div>
</div>



<div class="product-grid">
    <?php
    // Check if there are products to display
    if ($result->num_rows > 0) {
        // Loop through the result and display each product
        while($row = $result->fetch_assoc()) {
            echo '<a href="contact.html" class="product-card" title="Click for Enquiry">';
            echo '<img src="' . $row['image_url'] . '" alt="Product Image">';
            echo '<div class="product-info">';
            echo '<h3 class="product-title">' . $row['product_name'] . '</h3>';
            echo '<div class="product-category">' . $row['category'] . '</div>';
            echo '</div>';

            echo '</a>';
        }
    } else {
        echo "No products found";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>



<footer>
  <div class="footer-content">
      <div class="footer-section">
          <h3>Ganapati Build Mart</h3>
          <h4>Contact Information</h4>
          <p><strong>Address:</strong> Canal Road, Behind J K Petrol Pump,<br>
              Brahmani Tarang,<br>
              Vedvyas, Rourkela - 769004</p>
          <p><strong>Email:</strong> <a href="mailto:gbmrkl@gmail.com">gbmrkl@gmail.com</a></p>
          <p><strong>Phone:</strong> <a href="tel:+919437040874">+91 9437040874</a></p>
      </div>
      <div class="footer-section">
          <h3>Links</h3>
          <ul>
              <li><a href="/About.html">About Us</a></li>
              <li><a href="/shop.php">Products</a></li>
              <li><a href="/contact.html">Contact</a></li>
          </ul>
      </div>
      <div class="footer-section social-media">
          <h3>Follow Us</h3>
          <ul>
              <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
              <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
              <li><a href="#" target="_blank"><i class="fa-solid fa-globe"></i> Just Dial</a></li>
              <li><a href="#" target="_blank"><i class="fa-solid fa-globe"></i> India Mart</a></li>
          </ul>
      </div>
  </div>
  <div class="copyright">2025 Ganapati Build Mart. All rights reserved</div>
</footer>

</body>
</html>
