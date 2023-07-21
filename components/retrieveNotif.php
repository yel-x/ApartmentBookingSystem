<?php
require 'connect.php';

// Retrieve user information from the database
$query = "SELECT * FROM toastnotif";
$result = $conn->query($query);
$toastNotif = [];

// Store the retrieved user information in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $toastNotif[] = $row;
    }
}

// Close the database connection
$result->close();
?>