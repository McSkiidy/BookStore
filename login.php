<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = ""; 
$dbname = "Bookstore"; 

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user_email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Fetch the user row
        $row = $result->fetch_assoc();
        $hashed_password = $row['password']; // Assuming the hashed password is stored in the 'password' column
        
        // Verify the password
        if (password_verify($user_password, $hashed_password)) {
            $_SESSION['userdata'] = $user_email;
            header("Location: sample.php"); // Redirect to sample.php
            exit(); // Stop the script
        } else {
            $error_message = "Invalid Username or Password!!";
        }
    } else {
        $error_message = "Invalid Username or Password!!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<style>
    body {
        background-color: darkgoldenrod;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        animation: fadeIn 1s ease; /* Add fadeIn animation */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .container {
        max-width: 300px;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8); /* Add transparency to background */
        border-radius: 8px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        animation: slideIn 1s ease; /* Add slideIn animation */
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    h2 {
        text-align: center;
        color: #333;
    }
    input[type="email"],
    input[type="password"],
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    .error-message {
        color: red;
        text-align: center;
        margin-bottom: 10px;
    }

    a {
        color: blue; /* Change link color */
        text-decoration: none;
        display: block;
        margin-top: 20px;
        text-align: center;
    }
    .separator {
        text-align: center;
        margin: 20px 0;
        color: #999;
    }

    .separator a {
        color: #0a20e4;
        text-decoration: none;
    }

    .separator a:hover {
        text-decoration: underline;
    }
    a {
        color: blue; /* Change link color */
        text-decoration: none;
        display: block;
        margin-top: 20px;
        text-align: center;
    }
</style>
<body>

<div class="container">
    <h2>Login</h2>

    <?php
    if (!empty($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>

    <form action="login.php" method="post">      
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    
    <div class="separator">Or</div>
    <p style="text-align: center;">Don't have an account? <a href="register.php">Register</a></p>
    <a href="sample.php">Go Back</a>
</div>

</body>
</html>
