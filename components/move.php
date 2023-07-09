<?php
// Start or resume the session
session_start();

require 'retrieveCopy.php';

// Check if the form has been submitted and the user ID is present
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Check if the "Ongoing" button is clicked
    if (isset($_POST['moveToOngoing'])) {
        // Insert data into the Ongoing table
        $insertSql = "INSERT INTO ongoing (id, fName, lName, email, password) SELECT id, fName, lName, email, password FROM userinfocopy WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the userinfocopy table
        $deleteSql = "DELETE FROM userinfocopy WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();

        // Close the statements
        $insertStmt->close();
        $deleteStmt->close();

        // Set success message in session
        $_SESSION['successMessage'] = "Data moved to Ongoing successfully";

        // Redirect back to the table page with success message
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }


    // Check if the "Complete" button is clicked in the Ongoing table
    if (isset($_POST['moveToCompleteFromOngoing'])) {
        // Insert data into the Complete table
        $insertSql = "INSERT INTO complete (id, fName, lName, email, password) SELECT id, fName, lName, email, password FROM ongoing WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the ongoing table
        $deleteSql = "DELETE FROM ongoing WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();

        // Delete data from the userinfocopy table
        $copyDeleteSql = "DELETE FROM userinfocopy WHERE id = ?";
        $copyDeleteStmt = $conn->prepare($copyDeleteSql);
        $copyDeleteStmt->bind_param("i", $userId);
        $copyDeleteStmt->execute();

        // Close the statements
        $insertStmt->close();
        $deleteStmt->close();
        $copyDeleteStmt->close();

        // Set success message in session
        $_SESSION['successMessage'] = "Data moved to Complete from Ongoing successfully";

        // Redirect back to the table page with success message
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if the "Complete" button is clicked in the UserInfo table
    if (isset($_POST['moveToCompleteFromUserInfo'])) {
        // Insert data into the Complete table
        $insertSql = "INSERT INTO complete (id, fName, lName, email, password) SELECT id, fName, lName, email, password FROM userinfocopy WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the userinfocopy table
        $deleteSql = "DELETE FROM userinfocopy WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();

        // Close the statements
        $insertStmt->close();
        $deleteStmt->close();

        // Set success message in session
        $_SESSION['successMessage'] = "Data moved to Complete from UserInfo successfully";

        // Redirect back to the table page with success message
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Check if the form has been submitted and the user ID is present
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        // Check if the delete button is clicked
        if (isset($_POST['deleteFromComplete'])) {
            // Perform the deletion query here
            $deleteSql = "DELETE FROM complete WHERE id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $userId);
            $deleteStmt->execute();

            // Close the statement
            $deleteStmt->close();

            // Set success message in session
            $_SESSION['successMessage'] = "Succesfully deleted the row!";

            // Redirect back to the table page
            header("Location:  " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

}

?>