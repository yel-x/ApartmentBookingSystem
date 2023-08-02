<?php
require 'components/layout.php';
require 'components/retrieveRenters.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if the form is submitted and the email is provided
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Create a DELETE query to remove the row from the rented table based on the email
    $deleteQuery = "DELETE FROM rented WHERE email = '$email'";

    // Execute the DELETE query
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['successMessage'] = 'Renter Evicted';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Failed to remove, redirect back to the previous page with an error message
        header("Location: " . $_SERVER['HTTP_REFERER'] . "?errorMessage=Failed to remove.");
        exit();
    }
} else {
    // If the form is not submitted or email is not provided, redirect back to the previous page with an error message
    header("Location: " . $_SERVER['HTTP_REFERER'] . "?errorMessage=Email not provided.");
    exit();
}
?>