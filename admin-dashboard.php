<?php
require 'components/move.php';
require 'components/navbar.php';
require 'components/retrieveOngoing.php';
require 'components/retrieveComplete.php';
require 'components/retrieveAppointment.php';
require 'components/retrieveCopy.php';

// Replace YOUR_USER_ID with the actual ID of your user in the database
$yourUserId = 1;

// Initialize an empty array to store user data
$appointment = [];

// Check if the toast has already been shown
$toastShown = isset($_SESSION['toastShown']) && $_SESSION['toastShown'];

if (!$toastShown) {
    // Prepare the SQL query with a placeholder for the user ID
    $sql = "SELECT * FROM appointment WHERE id <> ? AND timestamp > ?";
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
            // Append each row to the $appointment array
            $appointment[] = $row;
        }
    }

    // Set the session variable to indicate that the toast has been shown
    $_SESSION['toastShown'] = true;

    // Close the statement
    $stmt->close();
}

// Prepare the SQL query to fetch all user data except for the user with ID 1
$sql = "SELECT * FROM appointment WHERE aID <> ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $yourUserId);
$stmt->execute();

// Get the result set from the executed statement
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through the result set and fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        // Append each row to the $appointment array
        $appointment[] = $row;
    }
}

// Close the statement
$stmt->close();

// Close the database connection
$conn->close();
?>


<title>Dashboard</title>
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
<?php if (!empty($appointment)): ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <?php foreach ($appointment as $user): ?>
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fas fa-bell pe-2"></i>
                        <strong class="me-auto">RPABS</strong>
                        <small class="text-body-secondary">Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        New data added for user
                        <?php echo $user['aID']; ?>:
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
<!-- breadcrumbs -->
<h1 class="mt-5 text-center fw-bold">Dashboard</h1>
<?php
$currentFile = basename($_SERVER['PHP_SELF']);
$isDashboard = $currentFile === 'admin-dashboard.php';
$isUserTable = $currentFile === 'userTable.php';
$isBookAppointment = $currentFile === 'bookAppointment.php';
?>

<nav aria-label="breadcrumb" id="breadcrumbs">
    <ol class="breadcrumb ms-5">
        <li class="breadcrumb-item <?php if ($isDashboard && !$isUserTable && !$isBookAppointment)
            echo 'active'; ?>">
            <?php if ($isDashboard && !$isUserTable && !$isBookAppointment): ?>
                Dashboard
            <?php else: ?>
                <a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a>
            <?php endif; ?>
        </li>
        <li class="breadcrumb-item <?php if ($isUserTable || $isBookAppointment)
            echo 'active'; ?>">
            <?php if ($isUserTable): ?>
                Book appointment
            <?php elseif ($isBookAppointment): ?>
                User Table
            <?php endif; ?>
        </li>
    </ol>
</nav>

<?php if ($isDashboard && !$isUserTable && !$isBookAppointment): ?>
    <div class="container d-flex justify-content-center">
        <div>
            <a href="#" id="userTableLink" class="breadcrumb-link text-decoration-none text-reset me-4 m-md-5">Book
                Appointment</a>
        </div>
        <?php if (!$isUserTable && !$isBookAppointment): ?>
            <div>
                <a href="#" id="bookAppointmentLink" class="breadcrumb-link text-decoration-none text-reset  m-0 m-md-5">Go to
                    User
                    Table</a>
            </div>
        <?php endif; ?>
    </div>
    <br>
    <hr>
<?php endif; ?>

<!-- book appointment Content -->
<div id="userTable" <?php if (!$isUserTable)
    echo 'style="display: none;"'; ?>>


    <!-- table -->
    <div class="container mt-3 mb-5 my-lg-5">
        <h1>New User List</h1>
        <div class="table-responsive">
            <?php if (empty($appointment)): ?> <!-- Check if the $appointment array is empty -->
                <p>No data available.</p> <!-- Display the "No data available" message -->
            <?php else: ?>
                <table class="table table-striped table-hover table-bordered shadow rounded-5">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Room Name</th>
                            <th>Schedule</th>
                            <th>Operation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($appointment as $user):
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
                                    <?php echo $user['title']; ?>
                                </td>
                                <td>
                                    <?php echo $user['date']; ?>
                                </td>
                                <td>
                                    <form action="admin-dashboard.php" method="post">
                                        <input type="hidden" name="userId" value="<?php echo $user['aID']; ?>">
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
                            <th>Room Name</th>
                            <th>Schedule</th>
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
                                    <?php echo $user['title']; ?>
                                </td>
                                <td>
                                    <?php echo $user['date']; ?>
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

                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Room Name</th>
                            <th>Schedule</th>
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
                                    <?php echo $user['fName']; ?>
                                </td>
                                <td>
                                    <?php echo $user['lName']; ?>
                                </td>
                                <td>
                                    <?php echo $user['email']; ?>
                                </td>
                                <td>
                                    <?php echo $user['title']; ?>
                                </td>
                                <td>
                                    <?php echo $user['date']; ?>
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
                                                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                                        Deletion
                                                    </h5>
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
</div>

<!-- User Table content -->
<div id="bookAppointment" class="container mt-3 mb-5 my-lg-5" style="display: none;" <?php if (!$isBookAppointment)
    echo 'style="display: none;"'; ?>>
    <h1>User Table</h1>
    <?php if (empty($userinfocopy)): ?>
        <p>No data available in this table.</p>
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
                                            <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                                Deletion
                                            </h5>
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

<script>
    document.getElementById('userTableLink').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('userTable').style.display = 'block';
        document.getElementById('bookAppointment').style.display = 'none';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php"></a></li><li class="breadcrumb-item active">Book Appointment</li></ol>';
        document.getElementById('userTableLink').style.display = 'none';
        document.getElementById('bookAppointmentLink').style.display = 'inline-block';
        var dashboardLink = document.createElement('a');
        dashboardLink.href = 'admin-dashboard.php?userId=<?php echo $userId; ?>';
        dashboardLink.textContent = 'Dashboard';
        document.getElementById('breadcrumbs').childNodes[0].prepend(dashboardLink);

        // Hide book appointment link
        document.getElementById('bookAppointmentLink').style.display = 'none';
    });

    document.getElementById('bookAppointmentLink').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('userTable').style.display = 'none';
        document.getElementById('bookAppointment').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php"></a></li><li class="breadcrumb-item active">User Table</li></ol>';
        document.getElementById('userTableLink').style.display = 'inline-block';
        document.getElementById('bookAppointmentLink').style.display = 'none';
        var dashboardLink = document.createElement('a');
        dashboardLink.href = 'admin-dashboard.php?userId=<?php echo $userId; ?>';
        dashboardLink.textContent = 'Dashboard';
        document.getElementById('breadcrumbs').childNodes[0].prepend(dashboardLink);

        // Hide user table link
        document.getElementById('userTableLink').style.display = 'none';
    });

    // Hide book appointment link if user is on the User Table page
    if ($isUserTable) {
        document.getElementById('bookAppointmentLink').style.display = 'none';
    }

</script>