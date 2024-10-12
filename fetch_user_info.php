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

// Fetch user info from the login table
$user = $_SESSION['username']; // Get the logged-in username
$sql = "SELECT fullName, email, mobileNumber FROM login WHERE username = ? ORDER BY loginTime DESC LIMIT 1"; // Get the latest login info
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Return user info as JSON
if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
    echo json_encode($userInfo);
} else {
    echo json_encode(['error' => 'User not found.']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
