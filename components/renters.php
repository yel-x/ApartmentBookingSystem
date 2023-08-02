<?php
require 'components/retrieveUserInfo.php';
require 'components/retrieveAppointment.php';

// Handle the "Rented" button submission
if (isset($_POST['moveFromUserTable']) && $_POST['operation'] === "move") {
    var_dump($_POST['userinfocopyEmail']);
    $userEmail = $_POST['userinfocopyEmail'];
    $advancePayment = $_POST['advancePay'];
    $dateToMove = $_POST['dateToMove'];

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
        $insertQuery = "INSERT INTO rented (fName, lName, email, password, cPassword, pfPicture, timestamp, advancePayment, dateMoved)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // Use your database connection object/method here
        $stmt1 = $conn->prepare($insertQuery);
        $stmt1->bind_param(
            "sssssssss", // <-- Updated type definition string
            $user['fName'], $user['lName'], $user['email'],
            $user['password'], $user['cPassword'], $user['pfPicture'], $user['timestamp'],
            $advancePayment,
            $dateToMove
        );
        if ($stmt1->execute()) {
            // Success message
            $_SESSION['successMessage'] = "Account is a renter now";

            // Step 5: Retrieve data from 'appointment' table
            $selectAppointmentQuery = "SELECT title, addOn, date, timestamp FROM appointment WHERE email = ?";
            $stmt3 = $conn->prepare($selectAppointmentQuery);
            $stmt3->bind_param("s", $user['email']);
            $stmt3->execute();
            $result = $stmt3->get_result();
            $appointmentData = $result->fetch_assoc();
            $stmt3->close();

            // Step 6: Insert 'title', 'addOn', 'date', and 'timestamp' data into 'complete' table
            $insertCompleteQuery = "INSERT INTO complete (fName, lName, email, title, addOn, date, timestamp)
                                   VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt4 = $conn->prepare($insertCompleteQuery);
            $stmt4->bind_param(
                "sssssss",
                $user['fName'], $user['lName'], $user['email'],
                $appointmentData['title'], $appointmentData['addOn'], $appointmentData['date'], $appointmentData['timestamp']
            );
            if ($stmt4->execute()) {

                // Step 7: Update 'title' and 'addOn' data in 'rented' table
                $updateRentedQuery = "UPDATE rented SET title = ?, addOn = ? WHERE email = ?";
                $stmt5 = $conn->prepare($updateRentedQuery);
                $stmt5->bind_param("sss", $appointmentData['title'], $appointmentData['addOn'], $user['email']);
                if ($stmt5->execute()) {

                    // Step 8: Delete the user from the 'appointment' table using the email
                    $deleteAppointmentQuery = "DELETE FROM appointment WHERE email = ?";
                    $stmt6 = $conn->prepare($deleteAppointmentQuery);
                    $stmt6->bind_param("s", $user['email']);
                    $stmt6->execute();
                    // Step 8: Delete the user from the 'userinfo' table using the email
                    $deleteUserQuery = "DELETE FROM userinfo WHERE email = ?";
                    $stmt7 = $conn->prepare($deleteUserQuery);
                    $stmt7->bind_param("s", $user['email']);
                    if ($stmt7->execute()) {
                        $_SESSION['successMessage'] .= "Account is now a renter";
                    } else {
                        $_SESSION['errorMessage'] = "Failed to delete user from userinfo table";
                    }
                    $stmt6->close();
                } else {
                    $_SESSION['errorMessage'] = "Failed to update appointment data in rented table";
                }
                $stmt5->close();
            } else {
                $_SESSION['errorMessage'] = "Failed to move appointment data to the complete table";
            }
            $stmt4->close();
        } else {
            $_SESSION['errorMessage'] = "Failed to insert user data into rented table";
        }
        $stmt1->close();

        // Redirect back to the table page
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>