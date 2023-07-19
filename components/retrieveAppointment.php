<?php
require 'connect.php';

// Retrieve user information from the database
$query = "SELECT * FROM appointment";
$result = $conn->query($query);
$appointment = [];

// Store the retrieved user information in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointment[] = $row;
    }
}

// Close the database connection
$result->close();
?>