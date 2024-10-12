<?php
session_start(); // Start the session
header('Content-Type: application/json'); // Set the content type to JSON

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'User not logged in.']);
    exit();
}

// Database connection
$servername = "localhost"; // Update if your MySQL server is different
$username = "root"; // Your MySQL username
$password = "Evo_fan_1065_red"; // Your MySQL password
$dbname = "banner"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Fetch user info from the signup table
$user = $_SESSION['username']; // Get the logged-in username
$sql = "SELECT fullName, email, mobileNumber FROM signup WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

$userInfo = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Return user info as JSON
if ($userInfo) {
    echo json_encode($userInfo);
} else {
    echo json_encode(['error' => 'User not found.']);
}
?>
