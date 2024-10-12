<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection setup
    $servername = "localhost";
    $username = "root";
    $password = "Evo_fan_1065_red";
    $dbname = "BANNER";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data safely
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $problem_type = mysqli_real_escape_string($conn, $_POST['problem-type']);
    $banner_location = mysqli_real_escape_string($conn, $_POST['banner-location']);
    $problem_description = mysqli_real_escape_string($conn, $_POST['problem-description']);

    // Handle file upload if there's an image
    $image_path = "";
    if (isset($_FILES['image-upload']) && $_FILES['image-upload']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image-upload']['name']);
        if (move_uploaded_file($_FILES['image-upload']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            echo "<script>alert('Error uploading file');</script>";
        }
    }

    // Insert form data into the database
    $sql = "INSERT INTO problem_reports (name, email, phone, problem_type, banner_location, problem_description, image_path)
            VALUES ('$name', '$email', '$phone', '$problem_type', '$banner_location', '$problem_description', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        // Success: Show alert and reload the same page
        echo "<script>alert('Report submitted successfully!'); window.location.href = 'http://localhost:8080/Banner%20Site/other-request.html';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    // Close connection
    $conn->close();
}
?>
