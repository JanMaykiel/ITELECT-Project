<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <header>
        <h1>Daily Thoughts</h1>

        <img src="images/profile.png" alt="Profile Picture">
    </header>
    <div class="nav-and-search">
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="my_blog.php">My Blog</a></li>
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
        <div class="blog-card">
            <img src="images/image1.jpg" alt="Blog Image">
            <div class="content">
                <h2>Blog title</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="meta">
                    <span>October 12, 2024</span>
                    <span>Travel</span>
                </div>
            </div>
        </div>
        <!-- Repeat similar cards -->
        <div class="blog-card">
            <img src="images/image2.jpg" alt="Blog Image">
            <div class="content">
                <h2>Blog title</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="meta">
                    <span>October 12, 2024</span>
                    <span>Travel</span>
                </div>
            </div>
        </div>

        <div class="blog-card">
            <img src="images/image3.jpg" alt="Blog Image">
            <div class="content">
                <h2>Blog title</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="meta">
                    <span>October 12, 2024</span>
                    <span>Travel</span>
                </div>
            </div>
        </div>

        <div class="blog-card">
            <img src="images/image4.jpg" alt="Blog Image">
            <div class="content">
                <h2>Blog title</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <div class="meta">
                    <span>October 12, 2024</span>
                    <span>Travel</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>