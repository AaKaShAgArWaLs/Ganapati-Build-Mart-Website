<?php
session_start();
require 'config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the user exists in the database
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];

        // Redirect to dashboard based on user type
        if ($user['user_type'] === 'admin') {
            header('Location: admin_dashboard.php');
        } else {
            header('Location: index.html');
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <h2>Admin Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                <?= $error ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" name="username" required>
                    <label>Email</label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
