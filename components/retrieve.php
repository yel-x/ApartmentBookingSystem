<?php
require 'components/connect.php';
// Initialize the $errors array
$errors = array();

// Check if the user ID is present in the URL
if (isset($_GET['userId'])) {
    // Get the user ID from the URL
    $userId = $_GET['userId'];
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
        $pfPicture = $row['pfPicture'];
        $password = $row['password'];
        $cPassword = $row['cPassword'];
    } else {

    }
} else {
    // User ID not present in the URL
}
?>