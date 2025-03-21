<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "user_system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch items from the database
$sql = "SELECT * FROM buy_sell";
$result = $conn->query($sql);

// Debugging: Check if any items are retrieved
if ($result->num_rows == 0) {
    echo "<h3 style='color:red; text-align:center;'>No items found!</h3>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .container {
            margin-top: 20px;
        }
        .item-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background: white;
        }
        .item-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Browse Items</h2>
    
    <!-- Search Bar -->
    <input type="text" id="search" class="form-control search-bar" placeholder="Search for an item...">

    <div class="row" id="item-container">
        <?php
        if ($result->num_rows > 0) {
            echo "<p>Items found: " . $result->num_rows . "</p>";
        } else {
            echo "<p>No items retrieved. Check database table.</p>";
        }
        
       while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4 mb-3 item-card' data-name='".strtolower($row['item_name'])."'>";
        echo "<img src='" . htmlspecialchars($row['image_path']) . "' alt='Item Image'>";

        echo "<h4>" . htmlspecialchars($row['item_name']) . "</h4>";
        echo "<a href='item-details.php?id=" . $row['id'] . "' class='btn btn-primary'>View Details</a>";


        echo "</div>";
    }
    
        ?>
    </div>
</div>

<script>
    // Search Filter
    document.getElementById("search").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll(".item-card");

        items.forEach(function(item) {
            let name = item.getAttribute("data-name");
            if (name.includes(filter)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
