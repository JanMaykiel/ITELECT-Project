<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

if (isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];
} else {
    $return_to = "admin_blog_details.php?id=" . $post['post_id'];
}

if (isset($_GET['id']) && isset($_GET['blog']) && !empty($_GET['id']) && !empty($_GET['blog'])) {
    $postId = $_GET['blog'];
    $commentId = $_GET['id'];
    //Delete the comment from the database
    $query = "DELETE FROM comments WHERE comment_id = ? AND post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $commentId, $postId);

    if ($stmt->execute()) {
        $query = "UPDATE posts SET comments = comments - 1 WHERE post_id = $postId LIMIT 1";
        $add = $conn->prepare($query);
        $add->execute();

        header("Location: admin_blog_details.php?id=$postId&success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

} else {
    echo "Invalid request.";
}

header("Location: $return_to");
die;
?>