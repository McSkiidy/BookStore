<?php
session_start(); // Start the session

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "Bookstore";

// Check if success message is stored in session
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = ''; // Initialize error message variable

try {
    $connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Safely get data from the POST request
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        
        // Check if the username already exists
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Username already exists, set the error message
            $error_message = "Error: Username already exists. Please choose a different username.";
        } else {
          $hashed_password= password_hash($password, PASSWORD_DEFAULT);
            // Username is unique, proceed with registration
            $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Set success message in session
            // $_SESSION['success_message'] = "Registered successfully!";
            
            // Redirect to prevent form resubmission
            header("Location: login.php");
            exit();
        }
    }
    
} catch(PDOException $e) {
    $error_message = "Error: " . $e->getMessage();
}

// Close the database connection
$connection = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
    input[type="text"],
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
    <h2>SignUp</h2>
    
    <?php
    if ($error_message !== '') {
        echo '<div style="background-color: rgba(255,0,0,0.7); color: white; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 10px;">' . $error_message . '</div>';
    }

    if ($success_message !== '') {
        echo '<div style="background-color: green; color: white; padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 10px;">' . $success_message . '<a href="login.php" style="margin-left: 10px;">Click here to login</a></div>';
        // Clear success message from session after displaying it
        unset($_SESSION['success_message']);
    }
    ?>

    <form action="register.php" method="post">      
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="SignUp">
    </form>
    
    <div class="separator">or</div>
    <p style="text-align: center;">Already have an account? <a href="login.php">Login</a></p>
    <a href="sample.php">Go Back</a>
</div>

</body>
</html>
