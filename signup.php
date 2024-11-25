<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password
    $confirm_password = md5($_POST['confirm_password']); // Hash confirm password

    if ($password === $confirm_password) {
        // Check if the email already exists
        $check_email = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email);

        if ($result->num_rows > 0) {
            // Email already exists
            header('Location: signup.html?error=exists');
            exit();
        } else {
            // Insert the user into the database
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

            if ($conn->query($sql) === TRUE) {
                header('Location: login.html?message=registered');
                exit();
            } else {
                header('Location: signup.html?error=server');
                exit();
            }
        }
    } else {
        header('Location: signup.html?error=password_mismatch');
        exit();
    }
}
?>