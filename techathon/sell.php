<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = $_POST['itemName'];
    $itemDetails = $_POST['itemDetails'];
    $price = $_POST['price'];
    $sellerName = $_POST['sellerName'];
    $contact = $_POST['contact'];

    // Image upload handling
    $target_dir = "uploads/";
    
    // Ensure upload directory exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["itemImage"]["name"]);
    move_uploaded_file($_FILES["itemImage"]["tmp_name"], $target_file);

    $sql = "INSERT INTO buy_sell (item_name, item_details, price, seller_name, contact, image_path) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsss", $itemName, $itemDetails, $price, $sellerName, $contact, $target_file);

    if ($stmt->execute()) {
        echo "<script>alert('Item listed successfully!'); window.location.href = 'buy.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
