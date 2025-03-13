<?php
require 'database/db.php'; // Ensure this file contains the database connection

// Check if the user is authenticated via a cookie or another method
if (!isset($_GET['uid'])) {
    header("Location: ./auth/index.php"); // Redirect to login if not authenticated
    exit();
}

$id = $_GET['uid']; // Get user email from cookie

// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


if (!$user) {
    header("Location: ./auth/index.php"); // Redirect if user not found
    exit();
}else{
    $name = $user['name'];
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding-top: 50px;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            font-weight: bold;
            color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-none d-md-block">
    <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="view_courses.php">Courses</a></li>
        <li class="nav-item"><a class="nav-link" href="view_users.php">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="notifications.php">Notifications</a></li>
        <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<main class="main-content">
    <h2>Welcome!</h2>
    <p>Your dashboard content goes here.</p>

    <!-- Statistics Section -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>Total Users</h5>
                <p><i class="bi bi-people"></i> 1,200</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>Total Courses</h5>
                <p><i class="bi bi-book"></i> 50</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>New Messages</h5>
                <p><i class="bi bi-envelope"></i> 5</p>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
