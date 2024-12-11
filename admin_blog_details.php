<?php
session_start();

include 'db.php';
include 'functions.php';

$user = check_login($conn);
//if the user is not loggen in redirect to login page
if (!$user) {
    header('Location: login.php?=not_logged_in');
    die;
}


// Get the post ID from the URL
if (isset($_GET['id'])) {
    $postId = intval($_GET['id']); // Sanitize the input
    $query = "SELECT * FROM posts WHERE post_id = '$postId'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo $postId;
        echo "Post not found!";
        exit;
    }
} else {
    echo "Invalid post ID!";
    exit;
}

$user_id = $post['user_id'];
$query = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $user_post = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];
    $query = "INSERT INTO comments (post_id, user_id, comment) VALUES ('$postId', '$user_id', '$comment')";
    if (mysqli_query($conn, $query)) {
        $query = "UPDATE posts SET comments = comments + 1 WHERE post_id = '$postId'";
        mysqli_query($conn, $query);
    }
}

// Fetch comments for the post
$query = "SELECT comments.comment, comments.post_id, comments.created_at, comments.comment_id, users.firstname, users.lastname, users.profile_path
          FROM comments
          JOIN users ON comments.user_id = users.user_id
          WHERE comments.post_id = ?
          ORDER BY comments.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/blog_details.css">
    <link rel="stylesheet" href="css/comments.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="admin_profile.php">
            <h4>
                <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
            </h4>
            <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="admin_home.php">Posts</a></li>
                <li><a href="admin_blog.php" class="active">My Blog</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="user_lists.php">User List</a></li>
                <li><a href="admin_profile.php">Profile</a></li>
            </ul>
        </nav>
    </div>

    <!-- Post Container -->
    <div class="post-container">
        <div class="post-title"><?= $post['post_title'] ?></div>
        <!-- Post Header -->
        <div class="post-header">
            <a class="info" href="view_profile.php?id=<?= $user_post['user_id'] ?>">
                <img src="uploads/<?= $user_post['profile_path'] ?>" alt="User Profile">
                <div class="author-info">
                    <h3><?= $user_post['firstname'] . " " . $user_post['lastname'] ?></h3>
                    <span><?= $post['date'] ?></span>
                </div>
            </a>
            <div class="post-category"><?= $post['category'] ?></div>
        </div>

        <!-- Post Image -->
        <img class="post-image" src='uploads/posts/<?= $post['image'] ?>' alt="Post Image">

        <!-- Post Content -->
        <div class="post-content">
            <p><?= $post['post'] ?></p>
        </div>

        <!-- Post Actions -->
        <div class="post-actions">
            <a href="like.php?id=<?= $post['post_id'] ?>" <button name="like"><span>❤️</span>
                <?= $post['likes'] ?></button></a>
            <span><span>💬</span> <?= $post['comments'] ?></span>
        </div>

        <!-- Comments Section -->
        <form action="admin_comment.php?id=<?= $post['post_id'] ?>" method="POST">
            <div class="comments-section">
                <h3>Comments:</h3>
                <textarea name="comment" placeholder="Leave a comment..."></textarea>
                <button type="submit">Post Comment</button>
            </div>
        </form>

        <div class="comments-block">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    include 'admin_delete_comments.php';
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }
            ?>
        </div>
    </div>
</body>