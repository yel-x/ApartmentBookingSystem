<?php
require 'connect.php';

// Retrieve data from rented table
$rented = array(); // Initialize as an empty array
// Retrieve rented data from the database
$query = "SELECT * FROM rented";
$result = $conn->query($query);

// Store the retrieved rented data in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rented[] = $row;
    }
}

// Check if the current user is a renter
$isRenter = false;
foreach ($rented as $renter) {
    if ($renter['email'] == $email) {
        $isRenter = true;
        $advancePayment = $renter['advancePayment'];
        $title = $renter['title'];
        break;
    }
}

?>