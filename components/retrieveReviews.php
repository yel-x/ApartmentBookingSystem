<?php
require 'connect.php';

// Retrieve data from reviews table
$reviews = array(); // Initialize as an empty array

// Retrieve reviews data from the database
$query = "SELECT * FROM reviews";
$result = $conn->query($query);

// Store the retrieved reviews data in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

?>