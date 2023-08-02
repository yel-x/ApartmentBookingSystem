<?php
require 'components/retrieveRenters.php';
require 'components/layout.php';
// Start the session
session_start();

// Retrieve the title from the form submission
$title = $_POST['title'];

// Ensure the title is not empty
if (!empty($title)) {
    // Get the current timestamp to set as the new dateMoved
    $currentTimestamp = time();

    // Update the dateMoved in the rented table with the current timestamp
    $updateQuery = "UPDATE rented SET dateMoved = FROM_UNIXTIME($currentTimestamp) WHERE title = '$title'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Successful update, set the success message in the session
        $_SESSION['successMessage'] = "Due date reset successful";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Error occurred during update, set the error message in the session
        $_SESSION['errorMessage'] = "Failed to reset due date";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Invalid title, set the error message in the session
    $_SESSION['errorMessage'] = "Invalid title";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>