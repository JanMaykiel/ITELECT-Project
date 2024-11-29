<?php
session_start();

include 'db.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password
    $confirm_password = md5($_POST['confirm_password']); // Hash confirm password

    $default_profile_pic = "uploads/default.png";

    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password) && !is_numeric($name)) {
        // All fields are filled save to database
        if ($password === $confirm_password) {
            // Check if the email already exists
            $check_email = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $check_email);

            if ($result->num_rows > 0) {
                // Email already exists
                header('Location: signup.php?error=exists');
                die;
            } else {
                // Insert the user into the database
                $user_id = random_num(8);
                $query = "INSERT INTO users (user_id, name, email, password, profile_path) VALUES ('$user_id', '$name', '$email', '$password', '$default_profile_pic')";

                mysqli_query($conn, $query);
                header('Location: login.php?message=registered');
                die;
            }
        } else {
            header('Location: signup.php?error=password_mismatch');
            die;
        }
    } else {
        header('Location: signup.php?error=invalid_data');
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Daily Thoughts</title>
    <link rel="stylesheet" href="css/login_signup.css">
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <h1>Sign Up</h1>
            <?php if (isset($_GET['error'])): ?>
                <p class="error-message">
                    <?php
                    if ($_GET['error'] === 'exists')
                        echo "Email already exists. Please use another.";
                    if ($_GET['error'] === 'password_mismatch')
                        echo "Passwords do not match.";
                    if ($_GET['error'] === 'invalid_data')
                        echo "Invalid data. Please check your input.";
                    if ($_GET['error'] === 'server')
                        echo "Server error. Please try again later.";
                    ?>
                </p>
            <?php endif; ?>
            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </div>
                <button type="submit" class="auth-button">Sign Up</button>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>