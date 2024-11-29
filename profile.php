<?php
session_start();

include 'db.php';
include 'functions.php';

check_login($conn);

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    die;
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $bio = htmlspecialchars($_POST['bio']);

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']['name']) && !empty($_FILES['profile_pic']['name'])) {
        $img_name = $_FILES['profile_pic']['name'];
        $temp_name = $_FILES['profile_pic']['tmp_name'];
        $img_size = $_FILES['profile_pic']['size'];
        $error = $_FILES['profile_pic']['error'];

        if ($error === 0) {
            if ($img_size > 2 * 1024 * 1024) {
                echo "File too large!";
                header('Location: profile.php?error=file_too_large');
                die;
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_to_lc, $allowed_exs)) {
                    if ($error === 0) {
                        if ($img_size < 2 * 1024 * 1024) {
                            $new_img_name = uniqid($name, true) . '.' . $img_ex_to_lc;
                            $img_upload_path = 'uploads/' . $new_img_name;
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
            header('Location: profile.php?error=upload_error');
        }

        // Update user details
        $update_query = "UPDATE users SET profile_path = '$new_img_name' WHERE user_id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            header('Location: profile.php?success=1');
            die;
        } else {
            echo "Error updating profile.";
        }
    }

    $update_query = "UPDATE users SET name = '$name', bio = '$bio' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        header('Location: profile.php?success=1');
        die;
    } else {
        echo "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="profile.php">
            <h4><?php echo $user['name']; ?></h4>
            <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </nav>
    </div>
    <div class="profile-container">
        <h1>Profile</h1>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Profile updated successfully!</p>
        <?php endif; ?>

        <div class="profile-card">
            <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>" class="profile-pic">
            <h2><?php echo $user['name']; ?></h2>
            <p><?php echo $user['email']; ?></p>
        </div>

        <h2>Edit Profile</h2>
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>

            <label for="profile_pic">Profile Picture:</label>
            <input type="file" id="profile_pic" name="profile_pic">

            <button type="submit">Update Profile</button>
            <a href="logout.php">Logout</a>
        </form>
    </div>
</body>

</html>