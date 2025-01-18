<?php
require 'config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database with 'normal' user type
        $query = "INSERT INTO users (username, password, user_type) VALUES (?, ?, 'normal')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $email, $hashed_password);

        if ($stmt->execute()) {
            header('Location: login.php');  // Redirect to login page
            exit();
        } else {
            $error = "Error creating account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <section class="header-nav">
        <div class="topnav">
            <div class="logo">
                <img src="assets/images/logo.svg" alt="Logo" class="logo-img">
            </div>
            <div class="nav-links">
                <a href="index.html">Home</a>
                <a href="Shop.html">Shop</a>
                <a href="About.html">About</a>
                <a href="Contact.html">Contact</a>
            </div>
        </div>
    </section>

    <div class="auth-container">
        <div class="auth-box">
            <h2>Sign Up</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" required>
                    <label>Confirm Password</label>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <p class="auth-link">Already have an account? <a href="login.html">Login</a></p>
        </div>
    </div>
</body>
</html>
