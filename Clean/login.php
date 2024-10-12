<?php
session_start(); // Start a session to store user data

$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "ThinkTank"; // Ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the values from the form
$email = $_POST['email'];
$password = $_POST['password']; // Using plain text as per your requirements

// Prepare and execute the SQL statement
$stmt = $conn->prepare("SELECT * FROM Users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] == 'Admin') {
        header("Location: admin-dashboard.html");
    } else {
        header("Location: home.html"); // Redirect to home page if user is not an admin
    }
} else {
    echo "<script>alert('Invalid email or password.'); window.location.href='login.html';</script>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
