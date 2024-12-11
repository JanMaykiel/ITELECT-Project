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

if ($user_data['user_type'] !== 'admin') {
    $redirect = "my_blog.php";
} else {
    $redirect = "admin_blog.php";
}

//Get the user id
$user_id = $_SESSION['user_id'];

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

$old_img = $post['image'];
if ($old_img !== 'default.png' && file_exists('uploads/posts/' . $old_img)) {
    unlink('uploads/posts/' . $old_img);
}
// delete the post form database
$query = "DELETE FROM posts WHERE post_id = '$postId' LIMIT 1";
if (mysqli_query($conn, $query)) {
    $query = "DELETE FROM likes WHERE post_id = '$postId' LIMIT 1";
    if (mysqli_query($conn, $query)) {
        header('Location: ' . $redirect . '?success=1');
    } else {
        header('Location: ' . $redirect . '?error=error_deleting');
        die;
    }
} else {
    header('Location: ' . $redirect . '?error=error_deleting');
    die;
}
?>