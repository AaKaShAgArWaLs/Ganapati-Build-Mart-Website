<?php
// Include database connection
require 'config.php';

// Start the session
session_start();

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy the session to logout
    session_destroy();
    header('Location: index.html');  // Redirect to home page
    exit();
}

// Add Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'] ? $_POST['description'] : NULL; // Allow NULL for description
    $created_at = date("Y-m-d H:i:s"); // Set created_at to current timestamp

    // Insert product into the database
    $sql = "INSERT INTO products (product_name, category, description, image_url, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $product_name, $category, $description, $image_url, $created_at, $created_at);
    if ($stmt->execute()) {
        $message = "Product added successfully!";
    } else {
        $message = "Failed to add product.";
    }
}

// Delete Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Failed to delete product.";
    }
}

// Edit Product
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Fetch product details
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'] ? $_POST['description'] : NULL; // Allow NULL for description
    $updated_at = date("Y-m-d H:i:s"); // Set updated_at to current timestamp

    // Update product
    $sql = "UPDATE products SET product_name = ?, category = ?, description = ?, image_url = ?, updated_at = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $product_name, $category, $description, $image_url, $updated_at, $id);
    if ($stmt->execute()) {
        $message = "Product updated successfully!";
        header('Location: admin_dashboard.php');  // Redirect after update
        exit();
    } else {
        $message = "Failed to update product.";
    }
}

// Fetch all products for display
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
    <h1>Admin Dashboard</h1>

    <?php if (isset($message)) { echo "<div class='message'>$message</div>"; } ?>

    <!-- Logout Button -->
    <a href="admin_dashboard.php?logout=true" class="logout-button">Logout</a>

    <!-- Add Product Form -->
    <h2>Add Product</h2>
    <form action="admin_dashboard.php" method="POST">
        <input type="text" name="product_name" placeholder="Product Name" required><br>
        <input type="text" name="category" placeholder="Category" required><br>
        <input type="text" name="image_url" placeholder="Image URL" required><br>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Edit Product Form -->
    <?php if (isset($product)): ?>
        <h2>Edit Product</h2>
        <form action="admin_dashboard.php" method="POST">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required><br>
            <input type="text" name="category" value="<?= $product['category'] ?>" required><br>
            <input type="text" name="image_url" value="<?= $product['image_url'] ?>" required><br>
            <button type="submit" name="edit_product">Update Product</button>
        </form>
    <?php endif; ?>

    <!-- Display all products -->
    <h2>Manage Products</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['product_name'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td>
                        <a href="admin_dashboard.php?edit=<?= $row['id'] ?>">Edit</a>
                        <a href="admin_dashboard.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
