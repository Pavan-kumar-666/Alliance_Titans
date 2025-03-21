<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Secure password hashing

// Check if email already exists
$checkUser = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($checkUser);
if ($result->num_rows > 0) {
    echo "Email already exists!";
} else {
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! Redirecting...";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
