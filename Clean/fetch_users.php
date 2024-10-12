<?php
$servername = "localhost";
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password
$dbname = "ThinkTank";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Only include passwords if the role is not Admin
        $row['password'] = $row['role'] !== 'Admin' ? $row['password'] : '***'; // Mask the password for Admin
        $users[] = $row;
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($users);
?>
