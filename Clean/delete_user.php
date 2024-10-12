<?php
$connection = new mysqli('localhost', 'root', '', 'ThinkTank');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the JSON body data
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['id']; // Get user ID from JSON body

if ($userId) {
    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM Users WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $userId); // Use "i" for integer binding

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting user."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "No user ID provided."]);
}

$connection->close();
?>
