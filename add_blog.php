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

    <div class="container">
        <h1>Create new blog:</h1>
        <form action="add_blog.php" method="POST" enctype="multipart/form-data">
            <div class="upload-container">
                <label for="image">
                    <div class="upload-box">drag and drop images <br> or <button type="button"
                            class="upload-button">Upload</button></div>
                </label>
                <input type="file" id="image" name="image" accept="image/*" hidden>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category" required>
                    <option value="Fitness">Fitness</option>
                    <option value="Food">Food</option>
                    <option value="Travel">Travel</option>
                    <!-- Add more categories as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" placeholder="Add Blog Title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Add Blog Description" required></textarea>
            </div>
            <div class="button-group">
                <a href="my_blog.php" class="cancel-button">Cancel</a>
                <button type="submit" class="post-button">Post</button>
            </div>
        </form>
    </div>
</body>

</html>