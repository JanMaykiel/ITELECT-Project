<?php
session_start();

include 'db.php';
include 'functions.php';

// Fetch post details
$query = "SELECT * FROM posts ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="login.php">
            <button type="submit" name="login" class="login">Login</button>
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
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
        <!-- Example of a blog post -->
        <?php
        foreach ($result as $user) {
            include 'post.php';
        }
        ?>
        <!-- Repeat similar cards -->
</body>

</html>