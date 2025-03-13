<?php
// Include database connection
require_once "../database/db.php"; // Ensure this file has proper DB connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"]; // Assume user is logged in and ID is available
    $course_name = $_POST["course_name"];
    $course_code = $_POST["course_code"];
    $semester = $_POST["semester"];

    // Insert course into database
    $sql = "INSERT INTO courses (user_id, course_name, course_code, semester) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$user_id, $course_name, $course_code, $semester])) {
        echo "<script>alert('Course registered successfully!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error registering course. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Course Registration</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">User ID</label>
                <input type="text" name="user_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course Name</label>
                <input type="text" name="course_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Course Code</label>
                <input type="text" name="course_code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="Fall">Fall</option>
                    <option value="Spring">Spring</option>
                    <option value="Summer">Summer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
