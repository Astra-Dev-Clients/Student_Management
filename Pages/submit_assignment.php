<?php
// Database connection
include '../database/db.php';

// Include Bootstrap CSS
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<style>
    body {
        margin: 20px;
        font-family: Arial, sans-serif;
    }
    .assignment-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .assignment-card h3 {
        margin-bottom: 10px;
    }
    textarea {
        width: 100%;
        resize: none;
    }
</style>';

// Fetch assignments with course names
$sql = "SELECT a.id, a.course_id, a.title, c.course_name 
    FROM assignments a
    JOIN courses c ON a.course_id = c.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h2 class='text-center mb-4'>Available Assignments</h2>";
    echo "<form method='POST' action='submit_response.php'>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='assignment-card'>";
        echo "<h3>Assignment ID: " . $row['id'] . "</h3>";
        echo "<p><strong>Course ID:</strong> " . $row['course_id'] . "</p>";
        echo "<p><strong>Course Name:</strong> " . $row['course_name'] . "</p>";
        echo "<p><strong>Title:</strong> " . $row['title'] . "</p>";
        echo "<label for='response_" . $row['id'] . "'>Your Response:</label><br>";
        echo "<textarea name='response_" . $row['id'] . "' rows='4' class='form-control'></textarea>";
        echo "</div>";
    }
    echo "<div class='text-center mt-4'>";
    echo "<button type='submit' class='btn btn-primary'>Submit Responses</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
} else {
    echo "<div class='container text-center'>";
    echo "<p class='alert alert-info'>No assignments available.</p>";
    echo "</div>";
}

$conn->close();
?>