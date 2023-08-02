<?php
require 'connect.php';

// Initialize the $errors array
$errors = array();

// Check if the user ID is present in the URL
if (isset($_GET['userId'])) {
    // Get the user ID from the URL
    $userId = $_GET['userId'];

    // Perform the query to retrieve user data from the userInfo table
    $sql_userInfo = "SELECT * FROM userInfo WHERE id = '$userId'";
    $result_userInfo = $conn->query($sql_userInfo);

    if ($result_userInfo->num_rows > 0) {
        // User data found in userInfo table
        $row = $result_userInfo->fetch_assoc();

        $fName = $row['fName'];
        $lName = $row['lName'];
        $email = $row['email'];
        $pfPicture = $row['pfPicture'];
        $password = $row['password'];
        $cPassword = $row['cPassword'];
    } else {
        // User not found in userInfo table, try fetching from the rented table
        $sql_rented = "SELECT * FROM rented WHERE id = '$userId'";
        $result_rented = $conn->query($sql_rented);

        if ($result_rented->num_rows > 0) {
            // User data found in rented table
            $row_rented = $result_rented->fetch_assoc();

            $fName = $row_rented['fName'];
            $lName = $row_rented['lName'];
            $email = $row_rented['email'];
            $pfPicture = $row_rented['pfPicture'];
            $password = $row_rented['password'];
            $cPassword = $row_rented['cPassword'];
        } else {
            // User not found in rented table either, set default values
            $fName = "Guest";
            $lName = "";
            $email = "";
            $pfPicture = "path/to/default/profile-picture.jpg"; // Replace with the default profile picture path
            $password = "";
            $cPassword = "";
        }
    }
} else {
    // User ID not present in the URL, set default values
    $fName = "Guest";
    $lName = "";
    $email = "";
    $pfPicture = "path/to/default/profile-picture.jpg"; // Replace with the default profile picture path
    $password = "";
    $cPassword = "";
}

// Retrieve data from rented table
$rented = array(); // Initialize as an empty array

// Retrieve rented data from the database
$query_rented = "SELECT * FROM rented";
$result_rented = $conn->query($query_rented);

// Store the retrieved rented data in an array
if ($result_rented->num_rows > 0) {
    while ($row_rented = $result_rented->fetch_assoc()) {
        $rented[] = $row_rented;
    }
}
?>