<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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
            z-index: 100;
            padding: 48px 0 0;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            font-weight: bold;
            color: #007bff;
        }
        .sidebar .close-btn {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .navbar {
            margin-bottom: 0;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        .sidebar.show + .main-content {
            margin-left: 250px;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .sidebar .close-btn {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Dashboard</a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <span class="close-btn">&times;</span>
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#courseManagementDropdownSidebar" aria-expanded="false" aria-controls="courseManagementDropdownSidebar">
                            Course Management <span class="float-end"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <div class="collapse" id="courseManagementDropdownSidebar">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="edit_course.php">Edit Course</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="view_courses.php">View Courses</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#userManagementDropdownSidebar" aria-expanded="false" aria-controls="userManagementDropdownSidebar">
                            User Management <span class="float-end"><i class="bi bi-chevron-down"></i></span>
                        </a>
                        <div class="collapse" id="userManagementDropdownSidebar">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="view_users.php">View Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="add_user.php">Add User</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 main-content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Courses</h5>
                            <p class="card-text">Manage and view all courses.</p>
                            <a href="view_courses.php" class="btn btn-primary">View Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text">Manage and view all users.</p>
                            <a href="view_users.php" class="btn btn-primary">View Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile</h5>
                            <p class="card-text">View and edit your profile.</p>
                            <a href="profile.php" class="btn btn-primary">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- analytics graph bar -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Analytics</h5>
                            <canvas id="analyticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('analyticsChart').getContext('2d');
                var analyticsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                        datasets: [{
                            label: 'User Registrations',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelector('.navbar-toggler').addEventListener('click', function () {
        document.querySelector('.sidebar').classList.toggle('show');
    });
    document.querySelector('.sidebar .close-btn').addEventListener('click', function () {
        document.querySelector('.sidebar').classList.remove('show');
    });
</script>
</body>
</html>
