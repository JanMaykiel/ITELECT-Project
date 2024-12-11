<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);
//check if user is logged in
if (!$user_data) {
    header('Location: login.php?=not_logged_in');
    die;
}

if ($user_data['user_type'] !== 'admin') {
    header('Location: login.php?=not_admin');
    die;
}

//Fetch the total number of users
$query = "SELECT * FROM users";

$result = mysqli_query($conn, $query);

// Prepare data
$userdata = [];
while ($row = mysqli_fetch_assoc($result)) {
    $userdata[] = $row;
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
    <link rel="stylesheet" href="css/user_lists.css">
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
                <li><a href="admin_blog.php">My Blog</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="user_lists.php" class="active">User List</a></li>
                <li><a href="admin_profile.php">Profile</a></li>
            </ul>
        </nav>
    </div>

    <div class="user_list">
        <div>
            <h2>Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date joined</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userdata as $row): ?>
                        <tr>
                            <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['user_type']; ?></td>
                            <td>
                                <a href="promote_user.php?id=<?= $row['user_id'] ?>"><button>Promote to
                                        Admin</button></a>
                                <a href="demote_user.php?id=<?= $row['user_id'] ?>"><button>Demote to User</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
</body>

</html>