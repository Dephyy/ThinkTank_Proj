<?php
// Start the session to access user data
session_start();

// Database connection settings
$servername = "localhost"; // Change if your database is on a different server
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "ThinkTank"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit an idea.");
}

// Get user ID from the session
$submitted_by = $_SESSION['user_id'];

// Get form data
$title = $_POST['title'];
$category = $_POST['category'];
$description = $_POST['description'];
$files_attached = "";

// Handle file upload if any
if (isset($_FILES['file_attachment']) && $_FILES['file_attachment']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file_attachment']['tmp_name'];
    $fileName = $_FILES['file_attachment']['name'];
    $fileSize = $_FILES['file_attachment']['size'];
    $fileType = $_FILES['file_attachment']['type'];
    
    // Specify the directory where you want to save the file
    $uploadFileDir = './uploaded_files/';
    $dest_path = $uploadFileDir . $fileName;
    
    // Move the file to the specified directory
    if(move_uploaded_file($fileTmpPath, $dest_path)) {
        $files_attached = $dest_path; // Save the path for database entry
    } else {
        echo "There was an error uploading the file.";
    }
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO Ideas (title, category, description, files_attached, submitted_by) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $title, $category, $description, $files_attached, $submitted_by);

// Execute the statement
if ($stmt->execute()) {
    echo "Idea submitted successfully!";
    echo "<script>alert('Your idea has been submitted successfully!'); window.location.href='home.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
