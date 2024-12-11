<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

//Get the user id
$user_id = $_SESSION['user_id'];

if ($user_data['user_type'] === 'admin') {
    $return_to = "admin_blog.php";
} else {
    $return_to = "my_blog.php";
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
// Handle blog post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $category = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $img_size = $_FILES['image']['size'];
        $error = $_FILES['image']['error'];
        $post_id = $post['post_id'];
        $old_img = $post['image'];

        if ($img_size > 8 * 1024 * 1024) {
            echo "File too large!";
            header('Location: edit_blog.php?error=file_too_large');
            die;
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_to_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png");
            if (in_array($img_ex_to_lc, $allowed_exs)) {

                $new_img_name = uniqid($post_id, true) . '.' . $img_ex_to_lc;
                $img_upload_path = 'uploads/posts/' . $new_img_name;
                if (!move_uploaded_file($temp_name, $img_upload_path)) {
                    header('Location: edit_blog.php?error=error_uploading');
                    die;
                }
            } else {
                header('Location: edit_blog.php?error=invalid_file_type');
                die;
            }
        }
    } else {
        $new_img_name = $post['image'];
    }

    $query = "UPDATE posts SET category = '$category', post_title = '$title', post = '$description', image = '$new_img_name' WHERE post_id = '$postId' LIMIT 1";
    // delete the old image
    if ($old_img !== 'default.png' && file_exists('uploads/posts/' . $old_img)) {
        unlink('uploads/posts/' . $old_img);
    }
    if (mysqli_query($conn, $query)) {
        header('Location: ' . $return_to . '?success=1');
        die;
    } else {
        header('Location: edit_blog.php?error=error_uploading');
        die;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/add_blog.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
    </header>

    <div class="container">
        <h1>Edit blog:</h1>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-message">
                <?php
                if ($_GET['error'] === 'file_too_large')
                    echo "Your file is too large.";
                if ($_GET['error'] === 'error_uploading')
                    echo "Error in uploading.";
                if ($_GET['error'] === 'invalid_file_type')
                    echo "Invalid file type.";
                ?>
            </p>
        <?php endif; ?>
        <form action="edit_blog.php?id=<?= $post['post_id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="upload-container">
                <label for="image">
                    <div class="upload-box">
                        <img class="img" src="uploads/posts/<?= $post['image'] ?>" alt="Post Image">
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" hidden>
                </label>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="Fitness" <?= $post['category'] === 'Fitness' ? 'selected' : '' ?>>Fitness</option>
                    <option value="Food" <?= $post['category'] === 'Food' ? 'selected' : '' ?>>Food</option>
                    <option value="Travel" <?= $post['category'] === 'Travel' ? 'selected' : '' ?>>Travel</option>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= $post['post_title'] ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?= $post['post'] ?></textarea>
            </div>
            <div class="button-group">
                <a href="my_blog.php" class="cancel-button">Cancel</a>
                <button type="submit" class="post-button">Update</button>
            </div>
        </form>

    </div>
</body>

</html>