<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/my_blog.css">
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
                <li><a href="my_blog.php" class="active">My Blog</a></li>
                <li><a href="about_us.php">About Us</a></li>
            </ul>
        </nav>
        <div class="search-category">
            <select>
                <option value="" selected disabled hidden>Categories</option>
                <option>Travel</option>
                <option>Lifestyle</option>
            </select>
            <input type="text" placeholder="Search...">
        </div>
    </div>


    <div class="blog-grid">
        <a href="add_blog.php" class="blog-card add-post">
            <div class="add-icon">+</div>
        </a>
        <!-- Example of a blog post -->
        <div class="blog-card">
            <img src="images/image1.jpg" alt="Traveling">
            <div class="content">
                <h2>Traveling</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="meta">
                    <span>October 29, 2023</span>
                    <span>Travel</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>