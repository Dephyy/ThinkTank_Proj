<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ThinkTank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_name = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Insert the user into the database with the role 'User'
$sql = "INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, 'User')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user_name, $email, $password);

if ($stmt->execute()) {
    // Redirect to login page after successful sign up
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
