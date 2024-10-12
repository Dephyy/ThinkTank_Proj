<?php
$connection = new mysqli('localhost', 'root', '', 'ThinkTank');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the JSON body data
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$role = $data['role'];

// Prepare the SQL UPDATE statement
$sql = "UPDATE Users SET username = ?, email = ?, password = ?, role = ? WHERE user_id = ?";
$stmt = $connection->prepare($sql);

// Use password only if provided, else leave it unchanged
if ($password) {
    // You can handle password hashing here if required, otherwise, just update the plain text
    $stmt->bind_param("ssssi", $username, $email, $password, $role, $userId);
} else {
    // Password will remain unchanged; we update other fields
    $sql = "UPDATE Users SET username = ?, email = ?, role = ? WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $role, $userId);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating user."]);
}

$stmt->close();
$connection->close();
?>
