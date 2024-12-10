<?php
session_start();

include 'db.php';
include 'functions.php';

$user_data = check_login($conn);

if (isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];
} else {
    $return_to = "user_lists.php";
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = intval($_GET['id']);
    echo "User ID received: $user_id";
    $query = "UPDATE users SET user_type = 'admin' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $query)) {
        header('Location: user_lists.php?success=1');
        die;
    } else {
        header('Location: user_lists.php?error=1');
        die;
    }
}

header("Location: $return_to");
die;
?>