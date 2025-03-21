<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Probability & Statistics PDFs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
        }
        .container {
            margin-top: 50px;
        }
        .pdf-box {
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Probability & Statistics PDFs</h2>

    <?php
    // Database connection
    $conn = new mysqli("localhost", "root", "", "user_system");

    // Check connection
    if ($conn->connect_error) {
        die("<p class='text-center text-danger'>Connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch PDFs from the database
    $sql = "SELECT * FROM pdf_materials WHERE subject_name = 'Probability and Statistics'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='pdf-box'>";
            echo "<p><strong>" . htmlspecialchars($row['pdf_name']) . "</strong></p>";

            // Fix: Ensure no duplicate "uploads/" in the path
            $pdfPath = $row['pdf_path'];  
            
            if (!empty($pdfPath)) {
                echo "<a href='" . htmlspecialchars($pdfPath) . "' target='_blank' class='btn btn-primary'>View PDF</a>";
            } else {
                echo "<p class='text-danger'>File not available</p>";
            }
            echo "</div>";
        }
    } else {
        echo "<p class='text-center text-danger'>No PDFs available.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
