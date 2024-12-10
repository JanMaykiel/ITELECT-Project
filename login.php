<?php
session_start();

include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password

    if (!empty($email) && !empty($password)) {
        // All fields are filled save to database

        // Read form the database
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $user_data = mysqli_fetch_assoc($result);
            if ($user_data['password'] === $password) {
                $_SESSION['user_id'] = $user_data['user_id'];
                if ($user_data['user_type'] === 'admin') {
                    header('Location: admin_dashboard.php');
                    die;
                }
                header('Location: index.php');
                die;
            } else {
                header('Location: login.php?error=invalid_data');
                die;
            }
        } else {
            header('Location: login.php?error=invalid_data');
            die;
        }
    } else {
        header('Location: login.php?error=invalid_data');
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Daily Thoughts</title>
    <link rel="stylesheet" href="css/login_signup.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Login</h1>
            <?php if (isset($_GET['error'])): ?>
                <p class="error-message">
                    <?php
                    if ($_GET['error'] === 'invalid_data')
                        echo "Wrong email or password.";
                    if ($_GET['error'] === 'server')
                        echo "Server error. Please try again later.";
                    ?>
                </p>
            <?php endif; ?>
            </p>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="auth-button">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>

</html>