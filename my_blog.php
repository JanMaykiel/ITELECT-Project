<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

$user_id = $_SESSION['user_id'];

//check if user is logged in
if (!$user_data) {
    header('Location: home.php?=not_logged_in');
    die;
}

// Fetch post details
$query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY id ASC";
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
    <link rel="stylesheet" href="css/my_blog.css">
    <link rel="stylesheet" href="css/delete.css">
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
                <li><a href="my_blog.php" class="active">My Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </nav>
        <div class="search-category">
            <form action="my_blog.php" method="GET">
                <select name="category" onchange="submit()">
                    <option value="" selected disabled hidden>Categories</option>
                    <option>All</option>
                    <option>Travel</option>
                    <option>Food</option>
                    <option>Fitness</option>
                </select>
            </form>
        </div>
    </div>


    <div class="blog-grid">
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            switch ($category) {
                case 'Travel':
                    $query = "SELECT * FROM posts WHERE category = 'Travel' AND user_id = '$user_id' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'Fitness':
                    $query = "SELECT * FROM posts WHERE category = 'Fitness' AND user_id = '$user_id' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'Food':
                    $query = "SELECT * FROM posts WHERE category = 'Food' AND user_id = '$user_id' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
                    break;
                case 'All':
                    $query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY id ASC";
                    $result = mysqli_query($conn, $query);
            }
        }
        ?>
        <a href="add_blog.php" class="blog-card add-post">
            <div class="add-icon">+</div>
        </a>

        <?php
        foreach ($result as $user) {
            include 'user_post.php';
        }
        ?>
    </div>
</body>

</html>