<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);
$user_id = $user_data['user_id'];

if (isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];
} else {
    $return_to = "blog_details.php?id=" . $post['post_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) {
        $postId = $_GET['id'];
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $comment = mysqli_real_escape_string($conn, $_POST['comment']); // Sanitize comment text

            if (!empty($comment)) {

                // Insert the comment into the database
                $query = "INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iis", $postId, $userId, $comment);

                if ($stmt->execute()) {
                    header("Location: blog_details.php?id=$postId"); // Redirect back to the post page
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            }
        } else {
            echo "You must be logged in to comment.";
        }
    } else {
        echo "Invalid request.";
    }
}

header("Location: $return_to");
die;
?>