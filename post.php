<div class="blog-card">
    <a href="blog_details.php" class="blog-details">
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
</div>