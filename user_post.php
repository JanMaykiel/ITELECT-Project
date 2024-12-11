<?php
if ($user_data['user_type'] !== 'admin') {
    $redirect = 'blog_details.php?id=';
} else {
    $redirect = 'admin_blog_details.php?id=';
}
?>

<div class="blog-card">
    <a href="<?php echo $redirect . $user['post_id'] ?>" class="blog-details">
        <img src="uploads/posts/<?= $user['image'] ?>" alt=" ">
        <div class="content">
            <h2><?php echo $user['post_title'] ?></h2>
            <p class="desc"><?php echo $user['post'] ?></p>
            <div class="meta">
                <span><?php echo $user['date'] ?></span>
                <span><?php echo $user['category'] ?></span>
            </div>

        </div>
    </a>
    <div class="buttons">
        <a href="edit_blog.php?id=<?php echo $user['post_id'] ?>" name="edit" class="edit">Edit</a>
        <a name="delete" class="delete" onclick="document.getElementById('delete_post').style.display='block'">Delete
            Post</a>
    </div>
</div>

<div id="delete_post" class="modal">
    <form class="modal-content" action="my_blog.php">
        <div class="container">
            <h1>Delete Post</h1>
            <p>Are you sure you want to delete your post?</p>

            <div class="clearfix">
                <a type="button" class="cancelbtn" href="my_blog.php">Cancel<a />
                    <a type="button" class="deletebtn"
                        href="delete_blog.php?id=<?php echo $user['post_id'] ?>">Delete</a>
            </div>
        </div>
    </form>
</div>