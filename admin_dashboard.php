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
    header('Location: home.php?=not_admin');
    die;
}

//Fetch the total number of users
$query = "SELECT COUNT(*) as total_users FROM users";
$userresult = mysqli_query($conn, $query);
$total_users = ($userresult && $userresult->num_rows > 0) ? $userresult->fetch_assoc()['total_users'] : 0;

// Fetch total number of posts
$query = "SELECT COUNT(*) as total_posts FROM posts";
$postresult = mysqli_query($conn, $query);
$total_posts = ($postresult && $postresult->num_rows > 0) ? $postresult->fetch_assoc()['total_posts'] : 0;

// Fetch user growth data
$query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS user_count
          FROM users
          GROUP BY month
          ORDER BY month ASC";

$result = mysqli_query($conn, $query);

// Prepare data
$userdata = [];
while ($row = mysqli_fetch_assoc($result)) {
    $userdata[] = $row;
}

// Fetch post growth data
$query = "SELECT DATE_FORMAT(date, '%Y-%m') AS month, COUNT(*) AS post_count
          FROM posts
          GROUP BY month
          ORDER BY month ASC";

$result = mysqli_query($conn, $query);

// Prepare data
$postdata = [];
while ($row = mysqli_fetch_assoc($result)) {
    $postdata[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>

        <a href="admin_profile.php">
            <h4>
                <?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?>
            </h4>
            <img src="uploads/<?= $user_data['profile_path'] ?: 'uploads/default.png'; ?>">
        </a>
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="admin_home.php">Posts</a></li>
                <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="user_lists.php">User List</a></li>
                <li><a href="admin_profile.php">Profile</a></li>
            </ul>
        </nav>
    </div>

    <div class="dashboard">
        <h1>Admin Dashboard</h1>
        <div class="card">
            <h2><?php echo $total_users; ?></h2>
            <p>Total Users</p>
        </div>
        <div class="card">
            <h2><?php echo $total_posts; ?></h2>
            <p>Total Posts</p>
        </div>
    </div>

    <div class="statictics">
        <div class="user_growth">
            <h2>User Growth (Monthly)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>User Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userdata as $row): ?>
                        <tr>
                            <td><?php echo $row['month']; ?></td>
                            <td><?php echo $row['user_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="post_growth">
            <h2>Number of Posts (Monthly)</h2>
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Posts Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($postdata as $row): ?>
                        <tr>
                            <td><?php echo $row['month']; ?></td>
                            <td><?php echo $row['post_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>