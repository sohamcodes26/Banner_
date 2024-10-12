<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status</title>
    <style>
        /* Basic Reset */
        <style>
    /* Basic Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #1b103b;
        color: white;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Change to flex-start */
        height: 100vh;
        overflow: auto; /* Allow scrollbars */
        padding: 20px; /* Add padding for better layout */
    }

    .container {
        text-align: center;
        max-width: 800px;
        background: linear-gradient(135deg, rgba(255, 105, 180, 0.8), rgba(255, 193, 7, 0.8));
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
    }

    h1 {
        font-size: 1.8rem;
        margin-bottom: 20px;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.4);
    }

    p {
        font-size: 1rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .request-list {
        margin-top: 20px;
        text-align: left;
        max-height: 400px; /* Set max height for scrollable area */
        overflow-y: auto; /* Enable vertical scrolling */
        border-top: 2px solid #fff; /* Add top border for separation */
        padding-top: 10px;
        padding-bottom: 10px; /* Add padding at the bottom */
    }

    .request-item {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px;
        margin: 10px 0;
        display: table; /* Use table layout */
        width: 100%; /* Full width */
        min-height: 80px; /* Set a minimum height */
    }

    .request-item p {
        margin: 5px 0; /* Reduce margin for items */
    }

    .view-button {
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none; /* Make link look like a button */
        display: inline-block; /* Align button properly */
    }

    .view-button:hover {
        background-color: #0056b3;
    }

    .back-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 0.9rem;
        color: #fff;
        background-color: #95143f;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .back-button:hover {
        background-color: #f50057;
    }
</style>

    </style>
</head>
<body>
    <div class="container">
        <h1>Status</h1>
        
        <?php
        session_start();
        
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

        // Fetch user's name from login table
        if (!isset($_SESSION['username'])) {
            echo '<p>User not logged in. Please log in to view your status.</p>';
            echo '<a href="index.html" class="back-button">Back to Home</a>';
            exit();
        }

        $username = $_SESSION['username'];
        $sql = "SELECT fullName FROM login WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userInfo = $result->fetch_assoc();
            $fullName = $userInfo['fullName'];

            // Prepare results array
            $results = [
                'digital_banners' => [],
                'problem_reports' => [],
                'qr_requests' => [],
            ];

            // Check digital_banners table
            $sql = "SELECT * FROM digital_banners WHERE name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $fullName);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $results['digital_banners'][] = $row;
            }

            // Check problem_reports table
            $sql = "SELECT * FROM problem_reports WHERE name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $fullName);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $results['problem_reports'][] = $row;
            }

            // Check qr_requests table
            $sql = "SELECT * FROM qr_requests WHERE name = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $fullName);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $results['qr_requests'][] = $row;
            }

            // Display results
            foreach ($results as $table => $entries) {
                if (!empty($entries)) {
                    echo '<h3>' . ucfirst(str_replace('_', ' ', $table)) . '</h3>';
                    echo '<div class="request-list">';
                    foreach ($entries as $entry) {
                        echo '<div class="request-item">';
                        foreach ($entry as $key => $value) {
                            echo '<p><strong>' . htmlspecialchars($key) . ':</strong> ' . htmlspecialchars($value) . '</p>';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                }
            }

            if (empty($results['digital_banners']) && empty($results['problem_reports']) && empty($results['qr_requests'])) {
                echo '<p>No requests found for your name.</p>';
            }
        } else {
            echo '<p>User not found in login table.</p>';
        }

        // Close connection
        $stmt->close();
        $conn->close();
        ?>
        <a href="index.html" class="back-button">Back to Home</a>
    </div>
</body>
</html>
