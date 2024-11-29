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
    <link rel="stylesheet" href="css/my_blog.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="profile.php">
            <h4><?php echo $user_data['name']; ?></h4>
            <img src="uploads/<?= $user_data['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_blog.php" class="active">My Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </nav>
        <div class="search-category">
            <select>
                <option value="" selected disabled hidden>Categories</option>
                <option>Travel</option>
                <option>Lifestyle</option>
            </select>
            <input type="text" placeholder="Search...">
        </div>
    </div>


    <div class="blog-grid">
        <a href="add_blog.php" class="blog-card add-post">
            <div class="add-icon">+</div>
        </a>
        <!-- Example of a blog post -->
        <div class="blog-card">
            <a href="blog_details.php" class="blog-details">
                <img src="images/image1.jpg" alt="Blog Image">
                <div class="content">
                    <h2>Traveling</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <div class="meta">
                        <span>October 12, 2024</span>
                        <span>Travel</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>