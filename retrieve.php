<?php
require 'connect.php';

// Check if the user ID is present in the URL
if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $userId = $_GET['id'];

    // Perform the query to retrieve user data
    $sql = "SELECT * FROM userInfo WHERE id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User data found
        $row = $result->fetch_assoc();

        // Access the user data fields
        $fName = $row['fName'];
        $lName = $row['lName'];
        $email = $row['email'];
        $uploaded_pfPicture = $row['pfPicture'];

    } else {
        // User data not found
        echo "User not found.";
    }
} else {
    // User ID not present in the URL
}
?>