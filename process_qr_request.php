<?php
// Database connection details
$servername = "localhost";  // or your server name
$username = "root";          // your MySQL username
$password = "Evo_fan_1065_red"; // your MySQL password
$dbname = "BANNER";          // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $qr_size = $conn->real_escape_string($_POST['qr-size']);
    $qr_content = $conn->real_escape_string($_POST['qr-content']);
    $instructions = $conn->real_escape_string($_POST['instructions']);

    // Insert form data into qr_requests table
    $insertRequest = "INSERT INTO qr_requests (name, email, phone, qr_size, qr_content, instructions) VALUES ('$name', '$email', '$phone', '$qr_size', '$qr_content', '$instructions')";
    
    if ($conn->query($insertRequest) === TRUE) {
        $requestId = $conn->insert_id; // Get the last inserted ID

        // Handle file upload
        if (isset($_FILES['files'])) {
            $file_path = 'uploads/'; // Ensure this directory exists
            foreach ($_FILES['files']['name'] as $key => $file_name) {
                $tmp_name = $_FILES['files']['tmp_name'][$key];
                // Move uploaded file
                if (move_uploaded_file($tmp_name, $file_path . basename($file_name))) {
                    // Insert file details into qr_uploads table
                    $insertUpload = "INSERT INTO qr_uploads (request_id, file_name, file_path) VALUES ($requestId, '$file_name', '$file_path$file_name')";
                    $conn->query($insertUpload);
                }
            }
        }

        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $insertRequest . "<br>" . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
