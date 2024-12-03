<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);
//check if user is logged in
if (!$user_data) {
    header('Location: home.php?=not_logged_in');
    die;
}

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
        <a href="profile.php">
            <h4>
                <?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?>
            </h4>
            <img src="uploads/<?= $user_data['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </nav>
        <div class="search-category">
            <form action="index.php" method="GET">
                <select name="category" onchange="submit()">
                    <option value="" selected disabled hidden>Categories</option>
                    <option>All</option>
                    <option>Travel</option>
                    <option>Food</option>
                    <option>Fitness</option>
                </select>
            </form>
            <input type="text" name="search" placeholder="Search...">
        </div>
    </div>
    <div class="blog-grid">
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            switch ($category) {
                case 'Travel':
                    $query = "SELECT * FROM posts WHERE category = 'Travel' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'Fitness':
                    $query = "SELECT * FROM posts WHERE category = 'Fitness' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'Food':
                    $query = "SELECT * FROM posts WHERE category = 'Food' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'All':
                    $query = "SELECT * FROM posts ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
            }
        }

        foreach ($result as $user) {
            include 'post.php';
        }
        ?>
        <!-- Repeat similar cards -->
</body>

</html>