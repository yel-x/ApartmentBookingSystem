<?php
require 'connect.php';

// Retrieve data from userinfocopy table
$userinfocopy = array(); // Initialize as an empty array

// Retrieve userinfocopy data from the database
$query = "SELECT * FROM userinfocopy";
$result = $conn->query($query);

// Store the retrieved userinfocopy data in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userinfocopy[] = $row;
    }
}

?>