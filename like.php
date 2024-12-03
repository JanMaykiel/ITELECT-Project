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

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = "SELECT * FROM likes WHERE post_id = '$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $likes = json_decode($row['likes'], true);

        if (!in_array($user_id, $likes)) {
            $likes[] = $user_id;
            $likes_string = json_encode($likes);

            $sql = "UPDATE likes set likes = '$likes_string' WHERE post_id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE posts set likes = likes + 1 WHERE post_id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
        } else {
            $key = array_search($user_id, $likes);
            unset($likes[$key]);
            $likes_string = json_encode($likes);

            $sql = "UPDATE likes set likes = '$likes_string' WHERE post_id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $sql = "UPDATE posts set likes = GREATEST(likes - 1, 0) WHERE post_id = '$id' LIMIT 1";
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $arr = [$user_id];
        $likes_string = json_encode($arr);
        $sql = "INSERT INTO likes (post_id, likes) VALUES ('$id', '$likes_string')";
        $result = mysqli_query($conn, $sql);
        $sql = "UPDATE posts set likes = likes + 1 WHERE post_id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $sql);
    }

}

header("Location: $return_to");
die;
?>