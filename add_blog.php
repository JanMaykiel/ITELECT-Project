<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

//Get the user id
$user_id = $_SESSION['user_id'];

// Handle blog post

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $post_id = random_num(20);

    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $img_name = $_FILES['image']['name'];
        $temp_name = $_FILES['image']['tmp_name'];
        $img_size = $_FILES['image']['size'];
        $error = $_FILES['image']['error'];

        if ($error === 0) {
            if ($img_size > 2 * 1024 * 1024) {
                echo "File too large!";
                header('Location: add_blog.php?error=file_too_large');
                die;
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_to_lc, $allowed_exs)) {
                    if ($error === 0) {
                        if ($img_size < 2 * 1024 * 1024) {
                            $new_img_name = uniqid($post_id, true) . '.' . $img_ex_to_lc;
                            $img_upload_path = 'uploads/posts/' . $new_img_name;
                            move_uploaded_file($temp_name, $img_upload_path);
                        } else {
                            echo "File too large!";
                        }
                    } else {
                        echo "There was an error uploading your file.";
                    }
                } else {
                    echo "You can't upload files of this type.";
                }
            }
        } else {
            echo "There was an error uploading your file.";
            header('Location: add_blog.php?error=upload_error');
        }

        // Update user details
        $query = "INSERT INTO posts (post_id, user_id, category, post_title, post, image) VALUES ('$post_id', '$user_id', '$category', '$title', '$description', '$new_img_name')";
        mysqli_query($conn, $query);
        if (mysqli_query($conn, $update_query)) {
            header('Location: add_blog.php?success=1');
            die;
        } else {
            echo "Error updating profile.";
        }
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

    <div class="container">
        <h1>Create new blog:</h1>
        <form action="add_blog.php" method="POST" enctype="multipart/form-data">
            <div class="upload-container">
                <label for="image">
                    <div class="upload-box">Upload an Image</div>
                    <input type="file" id="image" name="image" accept="image/*" hidden required>
                </label>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="Fitness">Fitness</option>
                    <option value="Food">Food</option>
                    <option value="Travel">Travel</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Add Blog Title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Add Blog Description" required></textarea>
            </div>
            <div class="button-group">
                <a href="my_blog.php" class="cancel-button">Cancel</a>
                <button type="submit" class="post-button">Post</button>
            </div>
        </form>
    </div>
</body>

</html>