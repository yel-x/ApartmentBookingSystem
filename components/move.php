<?php
// Start or resume the session
session_start();

require 'retrieveAppointment.php';
require 'components/retrieveCopy.php';

// Check if any checkboxes are selected
if (isset($_POST['selectedRow']) || isset($_POST['selectedRowOngoing']) || isset($_POST['selectedRowComplete'])) {
    $selectedRows = [];

    // Handle the data for "selectedRow" checkbox
    if (isset($_POST['selectedRow'])) {
        $selectedRows = array_merge($selectedRows, $_POST['selectedRow']);
    }

    // Handle the data for "selectedRowOngoing" checkbox
    if (isset($_POST['selectedRowOngoing'])) {
        $selectedRows = array_merge($selectedRows, $_POST['selectedRowOngoing']);
    }

    // Handle the data for "selectedRowComplete" checkbox
    if (isset($_POST['selectedRowComplete'])) {
        $selectedRows = array_merge($selectedRows, $_POST['selectedRowComplete']);
    }

    // Loop through the selected rows
    foreach ($selectedRows as $userId) {
        // Check if the "Ongoing" button is clicked
        if (isset($_POST['moveToOngoing'])) {
            // Insert data into the Ongoing table
            $insertSql = "INSERT INTO ongoing (id, fName, lName, email, title, date) SELECT aID, fName, lName, email, title, date FROM appointment WHERE aID = ?";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("i", $userId);
            $insertStmt->execute();

            // Delete data from the appointment table
            $deleteSql = "DELETE FROM appointment WHERE aID = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();

            // Close the statements
            $insertStmt->close();
            $deleteStmt->close();
        }

        // Check if the "Complete" button is clicked in the UserInfo table
        if (isset($_POST['moveToCompleteFromUserInfo'])) {
            // Insert data into the Complete table
            $insertSql = "INSERT INTO complete (id, fName, lName, email, title, date) SELECT aID, fName, lName, email, title, date FROM appointment WHERE aID = ?";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("i", $userId);
            $insertStmt->execute();

            // Delete data from the appointment table
            $deleteSql = "DELETE FROM appointment WHERE aID = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();

            // Close the statements
            $insertStmt->close();
            $deleteStmt->close();
        }

        // Check if the "Complete" button is clicked in the Ongoing table
        if (isset($_POST['moveToCompleteFromOngoing'])) {
            // Insert data into the Complete table
            $insertSql = "INSERT INTO complete (id, fName, lName, email, title, date) SELECT id, fName, lName, email, title, date FROM ongoing WHERE id = ?";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("i", $userId);
            $insertStmt->execute();

            // Delete data from the ongoing table
            $deleteSql = "DELETE FROM ongoing WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();

            // Delete data from the appointment table
            $copyDeleteSql = "DELETE FROM appointment WHERE aID = ?";
            $copyDeleteStmt = $conn->prepare($copyDeleteSql);
            $copyDeleteStmt->bind_param("i", $userId);
            $copyDeleteStmt->execute();

            // Close the statements
            $insertStmt->close();
            $deleteStmt->close();
            $copyDeleteStmt->close();
        }

        // Check if the delete button is clicked in the Complete table
        if (isset($_POST['deleteFromComplete'])) {
            // Perform the deletion query on the 'complete' table
            $deleteSqlComplete = "DELETE FROM complete WHERE id = ?";
            $deleteStmtComplete = $conn->prepare($deleteSqlComplete);
            $deleteStmtComplete->bind_param("i", $userId);
            $deleteStmtComplete->execute();
            $deleteStmtComplete->close();
        }
    }
    // Set success message in session
    $_SESSION['successMessage'] = "Data moved successfully";

    // Redirect back to the table page with success message
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

if (isset($_POST['deleteFromUserTable'])) {
    // Get the user ID from the POST data
    $userIdToDelete = $_POST['userId'];

    // Prepare the DELETE query
    $query = "DELETE FROM userinfocopy WHERE id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($query);

    // Bind the parameter (userId) to the statement
    $stmt->bind_param("i", $userIdToDelete);

    // Execute the DELETE query
    if ($stmt->execute()) {
        $_SESSION['successMessage'] = "Succesfully deleted an account";

        // Redirect back to the table page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>