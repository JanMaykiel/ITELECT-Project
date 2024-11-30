<?php

function check_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' limit 1";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }

        //Redirect to home page with login
        header("Location: index.php");
        die;
    } else {
        //Redirect to home page without login
        header("Location: home.php");
        die;
    }
}

function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    for ($i = 0; $i < $length; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}
?>