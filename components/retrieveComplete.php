<?php
include 'connect.php';

// Retrieve user information from the database
$query = "SELECT * FROM complete";
$result = $conn->query($query);
$completeUser = [];

// Store the retrieved user information in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $completeUser[] = $row;
    }
}

// Close the database connection
$result->close();

?>