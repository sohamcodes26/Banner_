<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Return logged in status
    echo json_encode(['loggedIn' => true, 'username' => $_SESSION['username']]);
} else {
    // User is not logged in
    echo json_encode(['loggedIn' => false]);
}
?>
