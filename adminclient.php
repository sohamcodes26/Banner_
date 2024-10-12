<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1b103b;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            background: #d1ccf1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #12273e;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #9c93ba;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .approve-button {
            background-color: #f0ad4e; /* Orange for the initial button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 10px;
            transition: background-color 0.3s;
        }

        .approved {
            background-color: green; /* Green when approved */
        }

        .approved:hover {
            background-color: darkgreen; /* Dark green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Administrator Dashboard</h2>

        <div class="search-container">
            <input type="text" id="search" placeholder="Search Clients..." onkeyup="searchClients()">
            <button onclick="addClient()">Add New Client</button>
        </div>

        <table id="clientsTable">
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Approvals</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "Evo_fan_1065_red";
                $dbname = "banner";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Delete client functionality
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
                    $clientId = $_POST['delete_id'];
                    $deleteSql = "DELETE FROM signup WHERE id = ?";
                    $deleteStmt = $conn->prepare($deleteSql);
                    $deleteStmt->bind_param("i", $clientId);

                    if ($deleteStmt->execute()) {
                        echo "<script>alert('Client deleted successfully.');</script>";
                    } else {
                        echo "<script>alert('Error deleting client: " . $conn->error . "');</script>";
                    }

                    $deleteStmt->close();
                }

                // Fetch clients from the signup table
                $sql = "SELECT id, fullName, email FROM signup"; // Fetching id, fullName, and email
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["fullName"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td><button class='approve-button' onclick='approveClient(this)'>Approve</button></td>"; // Approve button
                        echo "<td class='action-buttons'>";
                        echo "<form style='display:inline;' method='POST' onsubmit='return confirmDelete();'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row["id"] . "'>";
                        echo "<button type='submit'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No clients found.</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchClients() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('clientsTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < td.length - 1; j++) { // Exclude action column
                    if (td[j].innerText.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }

                tr[i].style.display = found ? "" : "none";
            }
        }

        function addClient() {
            alert("Redirecting to Add New Client Page...");
            // Implement the logic to redirect to the add client page
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this client?");
        }

        function approveClient(button) {
            if (button.innerText === 'Approve') {
                button.classList.add('approved');
                button.innerText = 'Approved';
            } else {
                button.classList.remove('approved');
                button.innerText = 'Approve';
            }
        }
    </script>
</body>
</html>
