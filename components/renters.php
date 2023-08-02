<?php
require 'components/retrieveUserInfo.php';

// Handle the "Rented" button submission
if (isset($_POST['moveFromUserTable']) && $_POST['operation'] === "move") {
    var_dump($_POST['userinfocopyEmail']);
    $userEmail = $_POST['userinfocopyEmail'];

    // Find the user in the $userinfo array using the email
    $user = null;
    foreach ($userinfo as $index => $u) {
        if ($u['email'] === $userEmail) {
            $user = $u;
            $userIndex = $index;
            break;
        }
    }

    if ($user) {
        // Insert user data into the 'rented' table
        $insertQuery = "INSERT INTO rented (fName, lName, email, password, cPassword, pfPicture, timestamp)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        // Use your database connection object/method here
        $stmt1 = $conn->prepare($insertQuery);
        $stmt1->bind_param(
            "sssssss",
            $user['fName'], $user['lName'], $user['email'],
            $user['password'], $user['cPassword'], $user['pfPicture'], $user['timestamp']
        );
        if ($stmt1->execute()) {
            // Delete the user from the 'userinfo' table using the email
            $deleteQuery = "DELETE FROM userinfo WHERE email = ?";
            $stmt2 = $conn->prepare($deleteQuery);
            $stmt2->bind_param("s", $user['email']);

            // Execute the deletion query
            if ($stmt2->execute()) {
                $_SESSION['successMessage'] = "Account is a renter now, and user deleted successfully";
            } else {
                $_SESSION['errorMessage'] = "Failed to delete user from userinfo table";
            }
        }
        // Close the statements
        $stmt1->close();
        $stmt2->close();

        // Redirect back to the table page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>