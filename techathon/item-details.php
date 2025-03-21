<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "user_system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate `id` in URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<h3 style='color:red; text-align:center;'>Invalid item!</h3>");
}

$id = intval($_GET['id']); // Convert to integer for security

// Fetch item details from database
$sql = "SELECT * FROM buy_sell WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("<h3 style='color:red; text-align:center;'>Item not found!</h3>");
}

$item = $result->fetch_assoc(); // Fetch item details

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Item Details</h2>

    <div class="card">
        <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Item Image">
        <div class="card-body">
            <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
            <p><strong>Details:</strong> <?php echo nl2br(htmlspecialchars($item['item_details'])); ?></p>
            <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($item['price']); ?></p>
            <p><strong>Seller:</strong> <?php echo htmlspecialchars($item['seller_name']); ?></p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($item['contact']); ?></p>
            <a href="buy.php" class="btn btn-primary">Back to Listings</a>
        </div>
    </div>
</div>

</body>
</html>
