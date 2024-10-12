<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "Evo_fan_1065_red"; // Your MySQL password
$dbname = "BANNER"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO digital_banners (name, email, phone, banner_size, banner_content, instructions, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $banner_size, $banner_content, $instructions, $file_path);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$banner_size = $_POST['ad-size'];
$banner_content = $_POST['ad-content'];
$instructions = $_POST['instructions'];
$file_path = ''; // Handle file upload if necessary

// Check if files are uploaded
if (!empty($_FILES['files']['name'][0])) {
    $upload_dir = 'uploads/'; // Make sure this directory exists and has the right permissions

    foreach ($_FILES['files']['name'] as $key => $name) {
        $tmp_name = $_FILES['files']['tmp_name'][$key];
        $file_path .= $upload_dir . basename($name) . ';'; // Save file paths separated by semicolon

        // Move the uploaded file to the specified directory
        move_uploaded_file($tmp_name, $upload_dir . basename($name));
    }
}

$stmt->execute();
$stmt->close();
$conn->close();

echo "New record created successfully";
?>
