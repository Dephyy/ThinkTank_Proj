<?php
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "ThinkTank";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO Users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $role);

// Get the values from the form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // Store as plain text for now
$role = "User"; // Set the role as 'User' by default

// Execute the statement
if ($stmt->execute()) {
    // If successful, return success response
    echo json_encode(["success" => true]);
} else {
    // If there is an error, return the error response
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

// Close the connection
$stmt->close();
$conn->close();
?>
