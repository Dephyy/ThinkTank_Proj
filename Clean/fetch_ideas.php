<?php
// Database connection settings
$host = 'localhost';
$dbname = 'ThinkTank';
$username = 'root';
$password = ''; // default password for XAMPP

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ideas from the database
$sql = "SELECT idea_id, title, category, description, files_attached, submitted_by FROM Ideas";
$result = $conn->query($sql);

$ideas = [];

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $ideas[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($ideas);

$conn->close();
?>
