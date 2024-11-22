<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/blog_details.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>

        <img src="images/profile.png" alt="Profile Picture">
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </nav>
    </div>

    <!-- Post Container -->
    <div class="post-container">
        <div class="post-title">Traveling</div>
        <!-- Post Header -->
        <div class="post-header">
            <img src="images/profile.png" alt="User Profile">
            <div class="author-info">
                <h3>@myusername.mail</h3>
                <span>6 hr. ago</span>
            </div>

            <div class="post-category">Travel</div>
        </div>

        <!-- Post Image -->
        <img class="post-image" src="images/image1.jpg" alt="Post Image">

        <!-- Post Content -->
        <div class="post-content">
            <p>Lorem ipsum dolor amet, consectetuer adipiscing elit. Faucibus blandit fames non efficitur vestibulum.
            </p>
        </div>

        <!-- Post Actions -->
        <div class="post-actions">
            <button><span>❤️</span> 1.1k</button>
            <button><span>💬</span> 212</button>
            <button><span>🔗</span> Share</button>
            <button class="menu-button">⋮</button>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <h3>Comments:</h3>
            <textarea placeholder="Leave a comment..."></textarea>
        </div>
    </div>
</body>