<?php
$connection = new mysqli('localhost', 'root', '', 'ThinkTank');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$username = $data['username'];
$email = $data['email'];
$password = $data['password'];

$sql = "UPDATE Users SET username = ?, email = ?, password = ? WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("sssi", $username, $email, $password, $userId);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["message" => "User updated successfully!"]);
} else {
    echo json_encode(["message" => "No changes made."]);
}

$stmt->close();
$connection->close();
?>
