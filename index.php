<?php
session_start(); // Start the session to access session variables
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banner Mukt City</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #1b103b;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .background-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('./WhatsApp Image 2024-09-29 at 11.08.14_30d922e1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.1;
            z-index: -1;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #1b103b;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        nav {
            background-color: #333;
            padding: 10px;
            border-radius: 25px;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        nav ul li a:hover {
            color: #ff5033;
        }

        .user-icons {
            display: flex;
            align-items: center;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
        }

        .auth-buttons button {
            margin-left: 10px;
            background-color: #ff5033;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 25px;
            cursor: pointer;
        }

        .auth-buttons button:hover {
            background-color: #ff7043;
        }

        /* Other styles... */
    </style>
</head>

<body>
    <div class="background-logo"></div>

    <header>
        <div class="logo">
            <img src="./WhatsApp Image 2024-09-29 at 11.08.14_30d922e1.jpg" alt="Logo">
            <h1>Go Digital</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="showSection('home')" class="nav-link active">Home</a></li>
                <li><a href="#" onclick="showSection('gallery')" class="nav-link">Gallery</a></li>
                <li><a href="#" onclick="showSection('feedback')" class="nav-link">Feedback</a></li>
                <li><a href="#" onclick="checkLoginStatus();" class="nav-link">Services</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><a href="logout.php">Sign Out</a></li>
                <?php else: ?>
                    <li><a href="login.php">Sign In</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Main content area -->
    <div id="content">
        <!-- Home Section -->
        <section id="home-section" class="content-section">
            <h2>OUR LATEST DIGITAL BANNER IDEAS & INNOVATIONS</h2>
            <p>Get ready to make a statement with our high-quality digital banners...</p>
        </section>

        <!-- Other Sections (Gallery, Feedback, etc.) -->
    </div>

    <script>
        // Function to show specific sections based on navigation
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(function (sec) {
                sec.style.display = 'none';
            });

            // Show the selected section
            document.getElementById(section + '-section').style.display = 'block';
        }

        // Check login state on page load
        window.onload = function () {
            const loggedInUser = <?php echo json_encode($_SESSION['username'] ?? null); ?>;
            if (loggedInUser) {
                document.getElementById('loggedInAs').innerText = `Logged in as ${loggedInUser}`;
                document.getElementById('authButtons').style.display = 'none'; // Hide login buttons
                document.getElementById('userStatus').style.display = 'block'; // Show user status
            } else {
                document.getElementById('authButtons').style.display = 'block'; // Show login buttons
                document.getElementById('userStatus').style.display = 'none'; // Hide user status
            }
        };

        function checkLoginStatus() {
            const loggedInUser = localStorage.getItem('loggedInUser');
            if (!loggedInUser) {
                alert("Please sign in to use the services.");
                window.location.href = 'login.php'; // Redirect to login page
            } else {
                window.open('requests.php', '_self'); // Redirect to services
            }
        }
    </script>
</body>

</html>
