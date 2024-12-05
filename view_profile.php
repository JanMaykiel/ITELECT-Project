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
    $userId = intval($_GET['id']); // Sanitize the input
    $query = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        echo $userId;
        echo "User not found!";
        exit;
    }
} else {
    echo "Invalid post ID!";
    exit;
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
            <h4><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h4>
            <img src="uploads/<?= $user['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
                <li><a href="profile.php">Profile</a></li>
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
                <img src="uploads/<?= $client['profile_path'] ?: 'uploads/default.png'; ?>" class="profile-pic">
            </div>
            <div>
                <h2><?php echo $client['firstname'] . ' ' . $client['lastname']; ?></h2>
                <p><?php echo $client['email']; ?></p>
            </div>
        </div>

        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo $client['firstname']; ?>" required
                    readonly>
            </div>

            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo $client['lastname']; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" readonly><?php echo $client['bio']; ?></textarea>
            </div>
        </form>
    </div>
</body>

</html>