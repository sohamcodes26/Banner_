<?php
// Database connection
$host = "localhost"; // Change this to your host
$dbname = "banner"; // Your database name
$username = "root"; // Database username
$password = "Evo_fan_1065_red"; // Your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = $_POST['fullName'];
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $mobileNumber = $_POST['mobileNumber'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

        // Insert user data into database
        $sql = "INSERT INTO signup (fullName, username, email, mobileNumber, password)
                VALUES (:fullName, :username, :email, :mobileNumber, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':username', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mobileNumber', $mobileNumber);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Redirect to login page after successful signup
        header("Location: login.html");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
