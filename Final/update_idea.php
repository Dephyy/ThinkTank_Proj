<?php
// update_idea.php

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

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

$idea_id = $data['idea_id'];
$title = $data['title'];
$category = $data['category'];
$description = $data['description'];

// Update query
$sql = "UPDATE Ideas SET title = ?, category = ?, description = ? WHERE idea_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $title, $category, $description, $idea_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Idea updated successfully"]);
} else {
    echo json_encode(["message" => "Error updating idea: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
