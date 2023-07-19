<?php
// Start or resume the session
session_start();

require 'retrieveAppointment.php';

// Check if the form has been submitted and the user ID is present
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Check if the "Ongoing" button is clicked
    if (isset($_POST['moveToOngoing'])) {
        // Insert data into the Ongoing table
        $insertSql = "INSERT INTO ongoing (id, fName, lName, email, title, date) SELECT aID, fName, lName, email, title, date FROM appointment WHERE aID = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the userinfocopy table
        $deleteSql = "DELETE FROM appointment WHERE aID = ?";
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
        $insertSql = "INSERT INTO complete (id, fName, lName, email, title, date) SELECT id, fName, lName, email, title, date FROM ongoing WHERE id = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the ongoing table
        $deleteSql = "DELETE FROM ongoing WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $userId);
        $deleteStmt->execute();

        // Delete data from the userinfocopy table
        $copyDeleteSql = "DELETE FROM appointment WHERE aID = ?";
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
        $insertSql = "INSERT INTO complete (id, fName, lName, email, title, date) SELECT aID, fName, lName, email, title, date FROM appointment WHERE aID = ?";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("i", $userId);
        $insertStmt->execute();

        // Delete data from the userinfocopy table
        $deleteSql = "DELETE FROM appointment WHERE aID = ?";
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
            // Perform the deletion query on the 'complete' table
            $deleteSqlComplete = "DELETE FROM complete WHERE id = ?";
            $deleteStmtComplete = $conn->prepare($deleteSqlComplete);
            $deleteStmtComplete->bind_param("i", $userId);
            $deleteStmtComplete->execute();
            $deleteStmtComplete->close();

            // Perform the deletion query on the 'userinfocopy' table
            $deleteSqlUserInfoCopy = "DELETE FROM userinfocopy WHERE id = ?";
            $deleteStmtUserInfoCopy = $conn->prepare($deleteSqlUserInfoCopy);
            $deleteStmtUserInfoCopy->bind_param("i", $userId);
            $deleteStmtUserInfoCopy->execute();
            $deleteStmtUserInfoCopy->close();

            // Set success message in session
            $_SESSION['successMessage'] = "Successfully deleted the row!";

            // Redirect back to the table page
            header("Location:  " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }


}

?>