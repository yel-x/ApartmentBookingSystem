<?php
// Start or resume the session
session_start();

require 'components/navbar.php';

// Replace YOUR_USER_ID with the actual ID of your user in the database
$yourUserId = 1;

// Initialize an empty array to store user data
$userInfo = [];

// Check if the toast has already been shown
$toastShown = isset($_SESSION['toastShown']) && $_SESSION['toastShown'];

if (!$toastShown) {
    // Prepare the SQL query with a placeholder for the user ID
    $sql = "SELECT * FROM userInfo WHERE id <> ? AND lastModified > ?";
    $stmt = $conn->prepare($sql);

    // Get the current timestamp
    $currentTimestamp = time();

    // Subtract an interval (e.g., 1 hour) from the current timestamp
    $interval = 3600; // 1 hour in seconds
    $lastModifiedThreshold = $currentTimestamp - $interval;

    $stmt->bind_param("is", $yourUserId, $lastModifiedThreshold);
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the result set and fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            // Append each row to the $userInfo array
            $userInfo[] = $row;
        }
    }

    // Set the session variable to indicate that the toast has been shown
    $_SESSION['toastShown'] = true;

    // Close the statement
    $stmt->close();
}

// Prepare the SQL query to fetch all user data except for the user with ID 1
$sql = "SELECT * FROM userInfo WHERE id <> ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $yourUserId);
$stmt->execute();

// Get the result set from the executed statement
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through the result set and fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        // Append each row to the $userInfo array
        $userInfo[] = $row;
    }
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();
?>


<title>Dashboard</title>


<?php

?>
<?php if (!empty($userInfo)): ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <?php foreach ($userInfo as $user): ?>
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fas fa-bell pe-2"></i>
                        <strong class="me-auto">RPABS</strong>
                        <small class="text-body-secondary">Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        New data added for user
                        <?php echo $user['id']; ?>:
                        <?php echo $user['fName']; ?>
                        <?php echo $user['lName']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Get the toast elements
        const toastElements = document.querySelectorAll('.toast');

        // Create a Toast instance for each toast element
        toastElements.forEach((toastElement) => {
            const toast = new bootstrap.Toast(toastElement);
            // toast.show();
        });
    </script>
<?php endif; ?>
<!-- table -->
<div class="container">
    <h1>User List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userInfo as $user): ?>
                <tr>
                    <td>
                        <?php echo $user['id']; ?>
                    </td>
                    <td>
                        <?php echo $user['fName']; ?>
                    </td>
                    <td>
                        <?php echo $user['lName']; ?>
                    </td>
                    <td>
                        <?php echo $user['email']; ?>
                    </td>
                    <td>
                        <?php echo $user['password']; ?>
                    </td>
                    <td>
                        <form action="move.php" method="post">
                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-danger rounded-pill btn-sm p-2"
                                name="moveToOngoing">Ongoing</button>
                            <button type="submit" class="btn btn-success rounded-pill btn-sm p-2"
                                name="moveToComplete">Complete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
// Check if a message is present in the session
if (isset($_SESSION['message'])) {
    // Display the message in a <div> element
    echo '<div class="message">' . $_SESSION['message'] . '</div>';

    // Clear the message from the session
    unset($_SESSION['message']);
}
?>