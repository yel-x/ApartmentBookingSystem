<?php
// Start or resume the session
session_start();

require 'components/retrieve.php';

// Check if the form has been submitted and the user ID is present
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Check if the "Ongoing" button is clicked
    if (isset($_POST['moveToOngoing'])) {
        // Insert data into the Ongoing table
        $insertSql = "INSERT INTO ongoing (id, fName, lName, email, password) SELECT id, fName, lName, email, password FROM userInfo WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Close the statement
        $insertStmt->close();

        // Set success message in session variable
        $_SESSION['message'] = "User successfully moved to Ongoing.";

        // Redirect back to the table page with userId parameter
        header("Location: admin-dashboard.php?userId=" . $userId);
        exit();
    }

    // Check if the "Complete" button is clicked
    if (isset($_POST['moveToComplete'])) {
        // Insert data into the Complete table
        $insertSql = "INSERT INTO complete (id, fName, lName, email, password) SELECT id, fName, lName, email, password FROM userInfo WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Close the statement
        $insertStmt->close();

        // Set success message in session variable
        $_SESSION['message'] = "User successfully moved to Complete.";

        // Redirect back to the table page with userId parameter
        header("Location: admin-dashboard.php?userId=" . $userId);
        exit();
    }
}

// Close the database connection
$conn->close();
?>