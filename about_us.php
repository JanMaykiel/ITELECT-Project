<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/aboutus.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="profile.php">
            <h4><?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?></h4>
            <img src="uploads/<?= $user_data['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="about_us.php" class="active">About Us</a></li>
            </ul>
        </nav>
    </div>
</body>