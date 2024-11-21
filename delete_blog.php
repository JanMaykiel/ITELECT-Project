<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blog_id'])) {
    $blog_id = intval($_POST['blog_id']);

    // Database connection
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete query
    $sql = "DELETE FROM blogs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);

    if ($stmt->execute()) {
        echo "Blog post deleted successfully.";
        header("Location: my_blog.php"); // Redirect back to the My Blog page
    } else {
        echo "Error deleting blog post: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>