<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_system";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if values are received
    if (!isset($_POST['email']) || !isset($_POST['issue'])) {
        die("Error: Missing form data!");
    }

    // Sanitize inputs
    $user_email = trim($_POST['email']);
    $issue = trim($_POST['issue']);

    // Validate inputs
    if (empty($user_email) || empty($issue)) {
        die("Please fill in all fields!");
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO reports (user_email, issue) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_email, $issue);

    if ($stmt->execute()) {
        echo "Report submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();
?>
