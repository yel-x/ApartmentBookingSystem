<?php
require 'components/move.php';
require 'components/navbar.php';
require 'components/retrieveOngoing.php';
require 'components/retrieveComplete.php';

// Replace YOUR_USER_ID with the actual ID of your user in the database
$yourUserId = 1;

// Initialize an empty array to store user data
$userInfoCopy = [];

// Check if the toast has already been shown
$toastShown = isset($_SESSION['toastShown']) && $_SESSION['toastShown'];

if (!$toastShown) {
    // Prepare the SQL query with a placeholder for the user ID
    $sql = "SELECT * FROM userInfoCopy WHERE id <> ? AND lastModified > ?";
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
            // Append each row to the $userInfoCopy array
            $userInfoCopy[] = $row;
        }
    }

    // Set the session variable to indicate that the toast has been shown
    $_SESSION['toastShown'] = true;

    // Close the statement
    $stmt->close();
}

// Prepare the SQL query to fetch all user data except for the user with ID 1
$sql = "SELECT * FROM userInfoCopy WHERE id <> ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $yourUserId);
$stmt->execute();

// Get the result set from the executed statement
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through the result set and fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        // Append each row to the $userInfoCopy array
        $userInfoCopy[] = $row;
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
<?php if (!empty($userinfocopy)): ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <?php foreach ($userinfocopy as $user): ?>
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
            toast.show();
        });
    </script>
<?php endif; ?>
<?php
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>' . $successMessage . '</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

    // Clear the success message from the session
    unset($_SESSION['successMessage']);
}
?>
<!-- table -->
<div class="container mt-3 mb-5 my-lg-5">
    <h1>New User List</h1>
    <div class="table-responsive">
        <?php if (empty($userinfocopy)): ?> <!-- Check if the $userinfocopy array is empty -->
            <p>No data available.</p> <!-- Display the "No data available" message -->
        <?php else: ?>
            <table class="table table-striped table-hover table-bordered shadow rounded-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($userinfocopy as $user):
                        ?>
                        <tr>
                            <td>
                                <?php echo $counter++; ?>
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
                                <form action="admin-dashboard.php" method="post">
                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger rounded-pill btn-sm p-2 mb-2 mb-lg-0"
                                        name="moveToOngoing">Ongoing</button>
                                    <button type="submit" class="btn btn-success rounded-pill btn-sm p-2  mb-lg-0"
                                        name="moveToCompleteFromUserInfo">Complete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Ongoing Table -->
<div class="container mb-5">
    <h1>Ongoing</h1>
    <div class="table-responsive">
        <?php if (empty($ongoingUser)): ?> <!-- Check if the $ongoingUser array is empty -->
            <p>No data available.</p> <!-- Display the "No data available" message -->
        <?php else: ?>
            <table class="table table-striped table-hover table-bordered shadow rounded-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($ongoingUser as $user):
                        ?>
                        <tr>
                            <td>
                                <?php echo $counter++; ?>
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
                                <form action="admin-dashboard.php" method="post">
                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-success rounded-pill btn-sm m-2"
                                        name="moveToCompleteFromOngoing">Complete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Complete Table -->
<div class="container mt-3 mb-5 my-lg-5">
    <h1>Complete</h1>
    <div class="table-responsive">
        <?php if (empty($completeUser)): ?> <!-- Check if the $completeUser array is empty -->
            <p>No data available.</p> <!-- Display the "No data available" message -->
        <?php else: ?>
            <table class="table table-striped table-hover table-bordered shadow rounded-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($completeUser as $user):
                        ?>
                        <tr>
                            <td>
                                <?php echo $counter++; ?>
                            </td>
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
                                <button type="button" class="btn btn-success rounded-pill btn-sm m-2" data-bs-toggle="modal"
                                    data-bs-target="#deleteConfirmationModal<?php echo $user['id']; ?>">
                                    Delete
                                </button>

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
                                    aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this row?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="admin-dashboard.php" method="post">
                                                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" class="btn btn-danger"
                                                        name="deleteFromComplete">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
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