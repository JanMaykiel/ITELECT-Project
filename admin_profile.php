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

if ($user_data['user_type'] !== 'admin') {
    header('Location: home.php?=not_admin');
    die;
}

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
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $bio = htmlspecialchars($_POST['bio']);
    $old_img = $user['profile_path'];

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']['name']) && !empty($_FILES['profile_pic']['name'])) {
        $img_name = $_FILES['profile_pic']['name'];
        $temp_name = $_FILES['profile_pic']['tmp_name'];
        $img_size = $_FILES['profile_pic']['size'];
        $error = $_FILES['profile_pic']['error'];

        if ($error === 0) {
            if ($img_size > 2 * 1024 * 1024) {
                echo "File too large!";
                header('Location: admin_profile.php?error=file_too_large');
                die;
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_to_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_to_lc, $allowed_exs)) {
                    if ($error === 0) {
                        if ($img_size < 8 * 1024 * 1024) {
                            $new_img_name = uniqid($fname, true) . '.' . $img_ex_to_lc;
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
            header('Location: admin_profile.php?error=upload_error');
        }

        // Update user details
        $update_query = "UPDATE users SET profile_path = '$new_img_name' WHERE user_id = '$user_id'";
        if ($old_img !== 'default.png' && file_exists('uploads/' . $old_img)) {
            unlink('uploads/' . $old_img);
        }
        if (mysqli_query($conn, $update_query)) {
            header('Location: admin_profile.php?success=1');
            die;
        } else {
            echo "Error updating profile.";
        }
    }

    if (!empty($fname) && !empty($lname) && !empty($bio) && !is_numeric($fname) && !is_numeric($lname)) {
        $update_query = "UPDATE users SET firstname = '$fname', lastname = '$lname', bio = '$bio' WHERE user_id = '$user_id'";
        if (mysqli_query($conn, $update_query)) {
            header('Location: admin_profile.php?success=1');
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
    <title>Profile</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>
        <a href="admin_profile.php">
            <h4><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h4>
            <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="admin_home.php">Posts</a></li>
                <li><a href="admin_blog.php">My Blog</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="user_lists.php">User List</a></li>
                <li><a href="admin_profile.php" class="active">Profile</a></li>
            </ul>
        </nav>
    </div>
    <div class="profile-container">
        <h1>Profile</h1>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Profile updated successfully!</p>
        <?php endif; ?>

        <div class="profile-card">
            <div>
                <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>" class="profile-pic">
            </div>
            <div>
                <h2><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h2>
                <p><?php echo $user['email']; ?></p>
            </div>
        </div>

        <h2>Edit Profile</h2>
        <form action="admin_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $user['firstname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo $user['lastname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" required><?php echo $user['bio']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="profile_pic">Profile Picture:</label>
                <input type="file" id="profile_pic" name="profile_pic">
            </div>
            <div class="button-group">
                <button type="submit" class="update">Update Profile</button>
                <a href="logout.php" class="logout">Logout</a>
            </div>
        </form>
    </div>
</body>

</html>