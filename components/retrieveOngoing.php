<?php
include 'connect.php';

// Retrieve user information from the database
$query = "SELECT * FROM ongoing";
$result = $conn->query($query);
$ongoingUser = [];

// Store the retrieved user information in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ongoingUser[] = $row;
    }
}

// Close the database connection
$result->close();

?>