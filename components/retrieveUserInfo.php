<?php
require 'connect.php';

// Retrieve data from userinfo table
$userinfo = array(); // Initialize as an empty array

// Retrieve userinfo data from the database
$query = "SELECT * FROM userinfo";
$result = $conn->query($query);

// Store the retrieved userinfo data in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userinfo[] = $row;
    }
}

?>