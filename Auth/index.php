<?php
require '../database/db.php';

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);  // Can be email or ID number
    $password = trim($_POST['password']);

    // Validate user input
    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if user exists using either email or ID number
        $sql = "SELECT id, u_name, pass FROM users WHERE email = ? OR id_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verify password
            if (password_verify($password, $user['pass'])) {
                // Redirect with user ID in URL instead of using session
                header("Location: ../dashboard/index.php?uid=" . urlencode($user['id']));
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url("../Assets/img/graduates.jpg"); /* Background Image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <h1>Student Manager</h1>
            <label for="username">Username (Email or ID Number):</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
            <p class="error-message"><?php echo $error; ?></p>
        </form>
    </div>
</body>
</html>
