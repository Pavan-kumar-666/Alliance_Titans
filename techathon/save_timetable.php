<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$date = $data["date"];
$timetable = $data["timetable"];

if (!$date || empty($timetable)) {
    echo "Invalid input!";
    exit;
}

// Delete existing timetable for the selected date
$conn->query("DELETE FROM timetable WHERE date = '$date'");

// Insert new timetable data
foreach ($timetable as $row) {
    $time_slot = $conn->real_escape_string($row["time_slot"]);
    $monday = $conn->real_escape_string($row["monday"]);
    $tuesday = $conn->real_escape_string($row["tuesday"]);
    $wednesday = $conn->real_escape_string($row["wednesday"]);
    $thursday = $conn->real_escape_string($row["thursday"]);
    $friday = $conn->real_escape_string($row["friday"]);

    $sql = "INSERT INTO timetable (date, time_slot, monday, tuesday, wednesday, thursday, friday) 
            VALUES ('$date', '$time_slot', '$monday', '$tuesday', '$wednesday', '$thursday', '$friday')";
    $conn->query($sql);
}

echo "Timetable saved successfully!";
$conn->close();
?>
