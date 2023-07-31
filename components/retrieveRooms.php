<?php
// Require the database connection file
require 'connect.php';

// Create a query to retrieve room information
$query = "SELECT * FROM rooms";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Create an array to store room data
    $rooms = array();

    // Fetch the data from the result set and store it in the $rooms array
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }

    mysqli_free_result($result);
} else {
    echo "Error executing the query: " . mysqli_error($conn);
}

?>