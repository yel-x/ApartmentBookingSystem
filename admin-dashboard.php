<?php
require 'components/move.php';
require 'components/navbar.php';
require 'components/retrieveOngoing.php';
require 'components/retrieveComplete.php';
require 'components/retrieveAppointment.php';
require 'components/retrieveNotif.php';
require 'components/retrieveCopy.php';

// Initialize an empty array to store user data
$appointment = [];

// Check if the toast has already been shown
$toastShown = isset($_SESSION['toastShown']) && $_SESSION['toastShown'];

// Variable to store the user IDs whose data is to be shown in the toast
$userIDsToShow = [];

if (!$toastShown) {
    $sql = "SELECT * FROM toastnotif WHERE timestamp > ?";
    $stmt = $conn->prepare($sql);

    // Get the current timestamp
    $currentTimestamp = time();

    // Subtract an interval (e.g., 1 hour) from the current timestamp
    $interval = 3600; // 1 hour in seconds
    $lastModifiedThreshold = $currentTimestamp - $interval;

    $stmt->bind_param("i", $lastModifiedThreshold);
    $stmt->execute();

    // Get the result set from the executed statement
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the result set and fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            // Append each row to the $appointment array
            $toastNotif[] = $row;
        }
    }

    // Set the session variable to indicate that the toast has been shown
    $_SESSION['toastShown'] = true;

    // Close the statement
    $stmt->close();
}

// Additional PHP code for data removal
if (isset($_POST['appointmentID'])) {
    $appointmentID = $_POST['appointmentID'];

    // Prepare the SQL query to delete the data
    $deleteSQL = "DELETE FROM toastnotif WHERE aID = ?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $appointmentID);

    // Execute the query
    if ($stmt->execute()) {
        // Data was successfully removed
        echo "Data removed from toastnotif table.";
    } else {
        // There was an error removing the data
        echo "Error removing data from toastnotif table.";
    }

    $stmt->close();
}
// Room Occupancy Analysis - Count the number of appointments for each room
$roomOccupancyQuery = "SELECT title, COUNT(*) AS room_count FROM appointment GROUP BY title";
$roomOccupancyResult = mysqli_query($conn, $roomOccupancyQuery);

$roomOccupancyData = array(
    'labels' => array(),
    'datasets' => array()
);

while ($row = mysqli_fetch_assoc($roomOccupancyResult)) {
    $roomOccupancyData['labels'][] = $row['title'];

    $dataset = array(
        'label' => $row['title'],
        'data' => array((int) $row['room_count']),
        'backgroundColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)',
        'borderColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 1)',
        'borderWidth' => 1
    );

    $roomOccupancyData['datasets'][] = $dataset;
}


// Daily/Weekly/Monthly Booking Trends - Debugging
$dailyWeeklyMonthlyQuery = "SELECT DATE(date) AS appointment_date, COUNT(*) AS appointment_count FROM appointment GROUP BY DATE(date)";
$dailyWeeklyMonthlyResult = mysqli_query($conn, $dailyWeeklyMonthlyQuery);

$dailyWeeklyMonthlyData = array();
while ($row = mysqli_fetch_assoc($dailyWeeklyMonthlyResult)) {
    $dailyWeeklyMonthlyData['dates'][] = $row['appointment_date'];
    $dailyWeeklyMonthlyData['counts'][] = (int) $row['appointment_count'];
}

// Prepare the SQL query to fetch all user data except for the user with ID 1
$sql = "SELECT * FROM appointment";
$stmt = $conn->prepare($sql);
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

<!-- toast -->
<?php if (!empty($toastNotif)): ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container top-0 end-0 p-3">
            <?php foreach ($toastNotif as $user): ?>
                <?php
                // Calculate the time difference between the current time and the appointment date
                $toastNotifTime = strtotime($user['date']); // Convert the appointment date to a timestamp
                $currentTime = time(); // Current time in seconds
                $timeDifference = $currentTime - $toastNotifTime;
                ?>
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                    data-user-id="<?php echo $user['aID']; ?>" data-time-ago="<?php echo $timeDifference; ?>">
                    <!-- Add the time difference attribute -->
                    <div class="toast-header">
                        <i class="fas fa-bell pe-2"></i>
                        <strong class="me-auto">RPABS</strong>
                        <small class="text-body-secondary">
                            <?php echo $timeDifference; ?> <!-- Pass the time difference as a parameter -->
                        </small>
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
        // JavaScript code for toast notification
        document.addEventListener("DOMContentLoaded", function () {
            function formatTimeAgo(timeDifference) {
                const intervals = {
                    year: 31536000,
                    month: 2592000,
                    week: 604800,
                    day: 86400,
                    hour: 3600,
                    minute: 60,
                    second: 1
                };

                for (const [key, value] of Object.entries(intervals)) {
                    const timeAgo = Math.floor(timeDifference / value);
                    if (timeAgo >= 1) {
                        return `Added ${timeAgo} ${key}${timeAgo > 1 ? 's' : ''} ago`;
                    }
                }
                return 'Just now';
            }
            // Function to remove the appointment data from the database
            function removeAppointmentFromDB(appointmentID) {
                // Send an AJAX request to the server to remove the data
                const xhr = new XMLHttpRequest();
                xhr.open("POST", ""); // Leave the URL empty to send the request to the current page

                // Set the request header to send form data
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                // Prepare the data to send in the request body
                const data = "appointmentID=" + encodeURIComponent(appointmentID);

                // Define the callback for when the request completes
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // The data was removed successfully from the database
                            console.log("Data removed from toastnotif table.");
                        } else {
                            // There was an error removing the data
                            console.error("Error removing data from toastnotif table.");
                        }
                    }
                };

                // Send the request with the appointment ID data
                xhr.send(data);
            }

            // Get the toast elements
            const toastElements = document.querySelectorAll(".toast");

            // Create a Toast instance for each toast element
            toastElements.forEach((toastElement) => {
                const toast = new bootstrap.Toast(toastElement);

                // Get the data-time-ago attribute from the toast element
                const timeAgoAttr = toastElement.getAttribute("data-time-ago");
                if (timeAgoAttr) {
                    const timeDifferenceInSeconds = parseInt(timeAgoAttr); // Parse the time difference to an integer in seconds

                    // Set the toast header content with the formatted time ago message
                    const toastHeader = toastElement.querySelector(".toast-header .text-body-secondary");
                    toastHeader.textContent = formatTimeAgo(timeDifferenceInSeconds);

                    // Hide the toast after a certain delay (e.g., 5 seconds)
                    setTimeout(() => {
                        toast.hide();
                    }, 5000); // 5000 milliseconds = 5 seconds

                    // Listen for the "hidden" event of the toast to remove the data
                    toastElement.addEventListener("hidden.bs.toast", function () {
                        const appointmentID = this.getAttribute("data-user-id");
                        removeAppointmentFromDB(appointmentID);
                    });

                    toast.show();
                }
            });
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
$isAddRooms = $currentFile === 'addRooms.php';
$isAddAddsOn = $currentFile === 'addAddsOn.php';
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
        <li class="breadcrumb-item <?php if ($isUserTable || $isBookAppointment || $isAddRooms || $isAddAddsOn)
            echo 'active'; ?>">
            <?php if ($isUserTable): ?>
                Book appointment
            <?php elseif ($isBookAppointment): ?>
                User Table
            <?php elseif ($isAddRooms): ?>
                Add new Rooms
            <?php elseif ($isAddAddsOn): ?>
                Add new AddsOn
            <?php endif; ?>
        </li>
    </ol>
</nav>

<?php if ($isDashboard && !$isUserTable && !$isBookAppointment && !$isAddRooms && !$isAddAddsOn): ?>
    <div id="navigationContainer" class="container mt-4">
        <div class="row">
            <div class="col col-12 col-md-6 mb-5">
                <a href="#" id="userTableLink"
                    class="breadcrumb-link text-decoration-none text-reset me-4 m-md-5 p-3 rounded rounded-3 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-calendar-check m-1" viewBox="0 0 16 16">
                        <path
                            d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    Book Appointment
                </a>
            </div>
            <div class="col col-12 col-md-6 mb-5">
                <a href="#" id="bookAppointmentLink"
                    class="breadcrumb-link text-decoration-none text-reset p-3 rounded rounded-3 shadow m-0 m-md-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-person-lines-fill m-1" viewBox="0 0 16 16">
                        <path
                            d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z" />
                    </svg>
                    Go to User Table
                </a>
            </div>
            <div class="col col-12 col-md-6 mb-5">
                <!-- Add Rooms Link -->
                <a href="#" id="addRoomsLink"
                    class="breadcrumb-link text-decoration-none text-reset p-3 rounded rounded-3 shadow m-0 m-md-5"><svg
                        xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-plus-lg m-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>Add New
                    Rooms</a>
            </div>
            <div class="col col-12 col-md-6 mb-5">
                <!-- Add AddsOn Link -->
                <a href="#" id="addOnsLink"
                    class="breadcrumb-link text-decoration-none text-reset p-3 rounded rounded-3 shadow m-0 m-md-5"><svg
                        xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                        class="bi bi-plus-lg m-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                    </svg>
                    Add
                    AddsOn</a>
            </div>
        </div>
    </div>
    <hr>
<?php endif; ?>

<!-- Create a container for the Room Occupancy Analysis Chart -->
<div id="occupancyChart" class="m-3 m-lg-5">
    <h2>Room Occupancy Analysis</h2>
    <canvas id="roomOccupancyChart"></canvas>
</div>

<!-- Create a container for the Daily/Weekly/Monthly Booking Trends Chart -->
<div id="trendingChart" class="m-3 m-lg-5">
    <h2>Daily/Weekly/Monthly Booking Trends</h2>
    <canvas id="bookingTrendsChart"></canvas>
</div>

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

<!-- Add rooms content -->
<div id="addRooms" style="display: none;">
    <h2>Add new Rooms</h2>
</div>
<!-- Add addsOn content -->
<div id="addOns" style="display: none;">
    <h2>Add new AddsOn</h2>
</div>

<script>
    function hideAllContent() {
        document.getElementById('userTable').style.display = 'none';
        document.getElementById('bookAppointment').style.display = 'none';
        document.getElementById('addRooms').style.display = 'none';
        document.getElementById('addOns').style.display = 'none';
        document.getElementById('occupancyChart').style.display = 'none';
        document.getElementById('trendingChart').style.display = 'none';
    }

    function hideNavigationContainer() {
        document.getElementById('navigationContainer').style.display = 'none';
    }

    function showNavigationContainer() {
        document.getElementById('navigationContainer').style.display = 'block';
    }

    function hideAllNavs() {
        document.getElementById('bookAppointmentLink').style.display = 'none';
        document.getElementById('userTableLink').style.display = 'none';
        document.getElementById('addRoomsLink').style.display = 'none';
        document.getElementById('addOnsLink').style.display = 'none';
    }

    function showNav(navId) {
        document.getElementById(navId).style.display = 'inline-block';
    }

    document.getElementById('userTableLink').addEventListener('click', function (event) {
        event.preventDefault();
        hideAllContent();
        hideAllNavs();
        hideNavigationContainer();
        showNav('userTableLink');
        document.getElementById('userTable').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">Book Appointment</li></ol>';
    });

    document.getElementById('bookAppointmentLink').addEventListener('click', function (event) {
        event.preventDefault();
        hideAllContent();
        hideAllNavs();
        hideNavigationContainer();
        showNav('bookAppointmentLink');
        document.getElementById('bookAppointment').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">User Table</li></ol>';
    });

    document.getElementById('addRoomsLink').addEventListener('click', function (event) {
        event.preventDefault();
        hideAllContent();
        hideAllNavs();
        hideNavigationContainer();
        showNav('addRoomsLink');
        document.getElementById('addRooms').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">Add new Rooms</li></ol>';
    });

    document.getElementById('addOnsLink').addEventListener('click', function (event) {
        event.preventDefault();
        hideAllContent();
        hideAllNavs();
        hideNavigationContainer();
        showNav('addOnsLink');
        document.getElementById('addOns').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">Add new AddsOn</li></ol>';
    });

    function createRoomOccupancyChart() {
        const ctx = document.getElementById('roomOccupancyChart').getContext('2d');
        const roomOccupancyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($roomOccupancyData['labels']) ?>,
                datasets: <?= json_encode($roomOccupancyData['datasets']) ?>
        },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Start y-axis from zero
                    }
                }
            }
        });
    }

    // Function to create the Daily/Weekly/Monthly Booking Trends Chart
    function createBookingTrendsChart() {
        const ctx = document.getElementById('bookingTrendsChart').getContext('2d');
        const bookingTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($dailyWeeklyMonthlyData['dates']) ?>,
                datasets: [{
                    label: 'Booking Trends',
                    data: <?= json_encode($dailyWeeklyMonthlyData['counts']) ?>,
                    fill: false,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time', // Use time scale for x-axis
                        time: {
                            unit: 'day' // Display data on a daily basis
                        }
                    },
                    y: {
                        beginAtZero: true // Start y-axis from zero
                    }
                }
            }
        });
    }

    // Call the functions to create the charts
    createRoomOccupancyChart();
    createBookingTrendsChart();
</script>