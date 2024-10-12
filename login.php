<?php
// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', 'Evo_fan_1065_red', 'banner');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if user exists
$sql = "SELECT * FROM signup WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if username exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) {
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['fullName'] = $row['fullName'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['mobileNumber'] = $row['mobileNumber'];

        // Delete all previous login information for all users
        $deleteSql = "DELETE FROM login"; // This will clear the entire login table
        $conn->query($deleteSql); // Execute the delete query

        // Insert new login information into the login table
        $insertSql = "INSERT INTO login (username, fullName, email, mobileNumber) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param('ssss', $username, $row['fullName'], $row['email'], $row['mobileNumber']);
        $insertStmt->execute();
        $insertStmt->close(); // Close insert statement

        // Return success message to JavaScript
        echo json_encode(['status' => 'success', 'username' => $username]);
    } else {
        echo json_encode(['status' => 'fail', 'message' => 'Invalid password']);
    }
} else {
    echo json_encode(['status' => 'fail', 'message' => 'User not found']);
}

// Close the original statement and connection
$stmt->close();
$conn->close();
?>
