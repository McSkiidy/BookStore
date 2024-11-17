<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <header>
        <h1>Welcome To Sharma's Library</h1>
        <h4>Explore the World of Books</h4>
        <?php
    // Check if user is logged in
    if(isset($_SESSION['userdata'])) {
        // Echo the user's name in the header
        echo "<h3>Welcome, {$_SESSION['userdata']}!</h3>";
        // echo $fetch_info['userdata'];
        echo "<h6> Now you can search for your book</h6>";
    }
    ?>
    </header>

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <!-- <a class="navbar-brand" href="sample.php">Bookstore</a>
    <button class = "navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button> -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="sample.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register/Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="confirmLogout()" id="logout" class="hidden">Logout</a>
            </li>
        </ul>
    </div>
    <div class="date-time">
        <span id="current-time"></span>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
            const formattedTime = now.toLocaleDateString('en-US', options);
            document.getElementById('current-time').textContent = formattedTime;
        }

        updateTime(); // Initial call

        // Update time every second
        setInterval(updateTime, 1000);
    </script>
</nav>
    <script>
    // Function to show/hide logout button based on login status
    window.onload = function() {
        var isLoggedIn = <?php echo isset($_SESSION['userdata']) ? 'true' : 'false'; ?>;
        var logoutButton = document.getElementById('logout');
        if (isLoggedIn) {
            logoutButton.classList.remove('hidden');
        } else {
            logoutButton.classList.add('hidden');
        }
    };

    </script>

    <form class="container" onsubmit="showBooks(); searchBooksGoogle();searchBooksOpenL(); fetchData(); return false">
        <input class= "form-control" type="text" name="searchInput" id="searchInput" placeholder="Enter book name" required>
        <button type="submit" class="btn btn-danger" id="searchButton">Search</button>
    </form>

    <!-- Yogananda Library Section -->
    <h2 id="slibrary-results-heading" class="hidden">Yogananda Library Books</h2>
    <div id="slibrary-results" class="hidden"></div>

    <!-- Google Books Section -->
    <h2 id="google-results-heading" class="hidden">Google Books</h2>
    <div id="google-results" class="hidden"></div>

    <!-- Open Library Section -->
    <h2 id="openl-results-heading" class="hidden">Open Library Books</h2>
    <div id="openl-results" class="hidden"></div>


<div id="helpBox" class="help-box">
    <h3>Welcome to the Library</h3>
    <p>This web project aims to streamline the process of accessing and exploring a diverse range of literary resources across multiple libraries. By integrating with the APIs provided by Google Books and Open Library, users can easily search for books based on their interests and preferences. The utilization of web scraping techniques for the Yogananda Library ensures that users have access to a comprehensive database of books, even if direct API access is not available.
        <br>
        <b>Furthermore, the project emphasizes the importance of user authentication for accessing the Yogananda Library books. By requiring users to log in, the project enhances security measures and ensures that only authorized individuals can access the library's collection.<br></b> 

        In terms of user experience, the project prioritizes simplicity and ease of navigation. The intuitive search functionality enables users to quickly find relevant books, while the categorized display of search results facilitates efficient browsing. The inclusion of a help box provides users with guidance on utilizing the search functionality effectively and understanding the scope of the project.

</div>

<!-- <button id="toggleHelpBox">Show Help Box</button> -->

<div id="footer" class="footer hidden">
    <p>&copy; 2024 Sharma's Bookstore. All rights reserved. | Designed by Shubham Sharma & Vijay Sajwan<br>
    <a href="feedback.html" style="color: rgb(4, 255, 0); text-decoration: underline;">Feel free to provide feedback..</a></p>
</div>
<script>
// Function to show the footer
function showFooter(){
        var footer = document.getElementById('footer');
        footer.classList.remove('hidden');
    }
    
    document.querySelector('form').addEventListener('submit', function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        
        // Call the function to show the footer when search is performed
        showFooter();
    });
</script>



    <script src="script.js"></script>

    <script src="script2.js"></script>
    <?php include_once('link.php'); ?>
    <script>
    var user = <?php echo isset($_SESSION['userdata']) ? 'true' : 'false'; ?>
    </script>
    


    <!-- Bootstrap JS and Popper.js (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
