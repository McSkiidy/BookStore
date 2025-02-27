<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>

<head>
    <title>Logout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .logout-message {
            padding: 20px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .logout-message h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .logout-message p {
            color: #666;
            margin-bottom: 20px;
        }

        .logout-message button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-message button:hover {
            background-color: #0056b3;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="logout-message">
        <h2>Logged Out Successfully</h2>
        <p>You have been logged out. Click below to return to the Home Page.</p>
        <button onclick="redirectToLogin()">Go To Home Page</button>
    </div>

    <script>
        function redirectToLogin() {
            window.location.href = 'sample.php';
        }
    </script>
</body>

</html>
