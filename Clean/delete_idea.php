<?php
// delete_idea.php

// Database connection
$servername = "localhost";
$username = "root"; // change if necessary
$password = ""; // change if necessary
$dbname = "ThinkTank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

// Get the idea ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$idea_id = $data['idea_id'];

// Delete query
$sql = "DELETE FROM Ideas WHERE idea_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idea_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Idea deleted successfully"]);
} else {
    echo json_encode(["message" => "Error deleting idea: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
