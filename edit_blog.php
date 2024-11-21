<?php
if (isset($_GET['blog_id'])) {
    $blog_id = intval($_GET['blog_id']);
    // Fetch blog data using $blog_id from the database
    header("Location: edit_blog_form.php?blog_id=$blog_id");
    exit;
}
?>