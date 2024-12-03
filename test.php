<?php
include 'db.php';

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
?>