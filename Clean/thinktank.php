<?php
$servername = "localhost"; // Usually 'localhost'
$username = "root"; // Your MySQL username, default is 'root'
$password = ""; // Your MySQL password, default is empty
$dbname = "thintank"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);




// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];

// Prepare and execute SQL query
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Check password (assuming passwords are stored as plain text for testing purposes)
    if ($user['password'] === $password) {
        // Login successful
        $response = ['success' => true, 'redirect' => $user['role'] === 'Admin' ? 'admin-dashboard.html' : 'home.html'];
    } else {
        // Invalid password
        $response = ['success' => false, 'message' => 'Invalid email or password.'];
    }
} else {
    // No user found
    $response = ['success' => false, 'message' => 'Invalid email or password.'];
}

$stmt->close();
$conn->close();

// Return response
header('Content-Type: application/json');
echo json_encode($response);
?>

//ADMIN DASHBOARD
<?php
// Include your database connection
include 'thinktank.php';

// Fetch users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);

$users = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = [
            'user_id' => $row['user_id'],
            'username' => htmlspecialchars($row['username'], ENT_QUOTES),
            'email' => htmlspecialchars($row['email'], ENT_QUOTES),
            'role' => htmlspecialchars($row['role'], ENT_QUOTES),
        ];
    }
    // Return JSON response
    echo json_encode($users);
} else {
    // Return error message if the query fails
    http_response_code(500);
    echo json_encode(['error' => 'Error fetching users: ' . $conn->error]);
}
?>


