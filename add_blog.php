<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Thoughts</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/add_blog.css">
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
                <li><a href="popular.php">Popular</a></li>
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

    <div class="header">
        <h1>Create new:</h1>
    </div>

    <div class="add-blog-form">
        <form action="add_blog.php" method="POST">
            <input type="file" id="image" name="image" required>
            <br>
            <div class="content">
                <label for="category">Category</label>
                <br>
                <select id="category" name="category" required>
                    <option value="" selected disabled hidden>Select Category</option>
                    <option>Travel</option>
                    <option>Lifestyle</option>
                </select>
                <br>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <button type="submit">Add Blog</button>
        </form>
</body>

</html>