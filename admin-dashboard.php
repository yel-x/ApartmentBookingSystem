<?php
require 'components/move.php';
require 'components/renters.php';
require 'components/navbar.php';
require 'components/retrieveNotif.php';

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
$roomOccupancyQuery = "SELECT title, COUNT(*) AS room_count FROM appointment GROUP BY title";
$roomOccupancyResult = mysqli_query($conn, $roomOccupancyQuery);

// Format the data for the doughnut chart
$data = [];
while ($row = mysqli_fetch_assoc($roomOccupancyResult)) {
    $data['labels'][] = $row['title'];
    $data['counts'][] = (int) $row['room_count'];
}

// Convert the data to JSON format
$chartData = json_encode($data);

// Daily Booking Trends
$dailyQuery = "SELECT DATE(date) AS appointment_date, COUNT(*) AS appointment_count FROM appointment GROUP BY DATE(date)";
$dailyResult = mysqli_query($conn, $dailyQuery);

$dailyData = array();
while ($row = mysqli_fetch_assoc($dailyResult)) {
    $dailyData['dates'][] = $row['appointment_date'];
    $dailyData['counts'][] = (int) $row['appointment_count'];
}

// Weekly Booking Trends
$weeklyQuery = "SELECT DATE(date) AS start_date, COUNT(*) AS appointment_count FROM appointment GROUP BY WEEK(date)";
$weeklyResult = mysqli_query($conn, $weeklyQuery);

$weeklyData = array();
while ($row = mysqli_fetch_assoc($weeklyResult)) {
    $weeklyData['dates'][] = $row['start_date'];
    $weeklyData['counts'][] = (int) $row['appointment_count'];
}

// Monthly Booking Trends
$monthlyQuery = "SELECT DATE_FORMAT(date, '%Y-%m') AS appointment_month, COUNT(*) AS appointment_count FROM appointment GROUP BY DATE_FORMAT(date, '%Y-%m')";
$monthlyResult = mysqli_query($conn, $monthlyQuery);

$monthlyData = array();
while ($row = mysqli_fetch_assoc($monthlyResult)) {
    $monthlyData['dates'][] = $row['appointment_month'];
    $monthlyData['counts'][] = (int) $row['appointment_count'];
}

// Combine the datasets into a single array
$trendsData = array(
    'daily' => $dailyData,
    'weekly' => $weeklyData,
    'monthly' => $monthlyData
);

// Encode the combined data array into JSON
$trendsDataJson = json_encode($trendsData);

?>
<style>
    #bookingTrendsChartContainer {
        overflow-x: scroll;
    }

    #bookingTrendsChart {
        width: 100%;
        height: auto;
    }

    /* CSS to make the canvas responsive on smaller screens */
    @media (max-width: 600px) {
        #bookingTrendsChart {
            width: 400px;
            height: 400px;
        }
    }
</style>
<title>Dashboard</title>

<?php

if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>' . $successMessage . '</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
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
                Rooms
            <?php elseif ($isAddAddsOn): ?>
                AddsOn
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
                    </svg>
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
                    AddsOn</a>
            </div>
        </div>
    </div>
    <hr>
<?php endif; ?>

<!-- chart reports -->
<div id="chartReports">
    <!-- Create a container for the Room Occupancy Analysis Chart -->
    <div class="mb-5 d-flex justify-content-center"> <!-- Apply d-flex and justify-content-center classes here -->
        <div>
            <h4>Room Occupancy Analysis</h4>
            <canvas id="roomOccupancyChart"></canvas>
        </div>
    </div>
    <!-- Create a container for the Daily/Weekly/Monthly Booking Trends Chart -->
    <div class="mx-3" id="bookingTrendsChartContainer">
        <h4>Daily/Weekly/Monthly Booking Trends</h4>
        <canvas id="bookingTrendsChart"></canvas>
    </div>
</div>

<!-- book appointment Content -->
<div id="userTable" <?php if (!$isUserTable)
    echo 'style="display: none;"'; ?>>
    <!-- New user table -->
    <div class="container mt-3 mb-5 my-lg-5">
        <h1>New User List</h1>
        <div class="table-responsive" id="paginationContainer">
            <!-- The table and pagination will be loaded here using AJAX -->
        </div>
    </div>

    <!-- Ongoing Table -->
    <div class="container mb-5">
        <h1>Ongoing</h1>
        <div class="table-responsive" id="paginationContainerOngoing">
            <!-- The ongoing table and pagination will be loaded here using AJAX -->
        </div>
    </div>

    <!-- Complete Table -->
    <div class="container mb-5">
        <h1>Complete</h1>
        <div class="table-responsive" id="paginationContainerComplete">
            <!-- The complete table and pagination will be loaded here using AJAX -->
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
    <?php include 'userTable.php'; ?>
    <?php include 'rentersTable.php'; ?>
</div>

<!-- Add rooms content -->
<div id="addRooms" class="container mt-3 mb-5 my-lg-5" <?php if (!$isAddRooms)
    echo 'style="display: none;"'; ?>>
    <?php include 'Rooms.php'; ?>
</div>

<!-- Add addsOn content -->
<div id="addOns" class="container mt-3 mb-5 my-lg-5" <?php if (!$isAddAddsOn)
    echo 'style="display: none;"'; ?>>
    <?php include 'addOns.php'; ?>
</div>

<script>
    // Function to load the next page content for new user table via AJAX
    function loadNextPage(page) {
        $.ajax({
            url: 'pagination/pagination_script.php', // Replace with the URL of your PHP script that generates the next page content
            data: { page: page },
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $('#paginationContainer').html(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Attach a click event to the pagination links
    $(document).on('click', '.page-link', function (event) {
        event.preventDefault();
        var nextPage = $(this).attr('href').split('?page=')[1];
        loadNextPage(nextPage);
    });

    // Initial loading of the first page on page load
    $(document).ready(function () {
        loadNextPage(1);
    });

    // Function to load the next page content via AJAX for the ongoing table
    function loadOngoingTable(page) {
        $.ajax({
            url: 'pagination/pagination_ongoing_script.php', //
            data: { page: page },
            type: 'GET',
            dataType: 'html',
            success: function (data) {

                $('#paginationContainerOngoing').html(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Attach a click event to the pagination links for the ongoing table
    $(document).on('click', '#paginationContainerOngoing .page-link', function (event) {
        event.preventDefault();
        var nextPage = $(this).attr('href').split('?page=')[1];
        loadOngoingTable(nextPage);
    });

    // Initial loading of the first page for the ongoing table on page load
    $(document).ready(function () {
        loadOngoingTable(1);
    });

    // Function to load the next page content via AJAX for the complete table
    function loadCompleteTable(page) {
        $.ajax({
            url: 'pagination/pagination_complete_script.php', // Replace with the correct file path
            data: { page: page },
            type: 'GET',
            dataType: 'html',
            success: function (data) {
                $('#paginationContainerComplete').html(data);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Attach a click event to the pagination links for the complete table
    $(document).on('click', '#paginationContainerComplete .page-link', function (event) {
        event.preventDefault();
        var nextPage = $(this).attr('href').split('?page=')[1];
        loadCompleteTable(nextPage);
    });

    // Initial loading of the first page for the complete table on page load
    $(document).ready(function () {
        loadCompleteTable(1);
    });

</script>

<script>
    function hideAllContent() {
        document.getElementById('userTable').style.display = 'none';
        document.getElementById('bookAppointment').style.display = 'none';
        document.getElementById('addRooms').style.display = 'none';
        document.getElementById('addOns').style.display = 'none';
        document.getElementById('chartReports').style.display = 'none';
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
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">Rooms</li></ol>';
    });

    document.getElementById('addOnsLink').addEventListener('click', function (event) {
        event.preventDefault();
        hideAllContent();
        hideAllNavs();
        hideNavigationContainer();
        showNav('addOnsLink');
        document.getElementById('addOns').style.display = 'block';
        document.getElementById('breadcrumbs').innerHTML = '<ol class="breadcrumb ms-5"><li class="breadcrumb-item"><a href="admin-dashboard.php?userId=<?php echo $userId; ?>">Dashboard</a></li><li class="breadcrumb-item active">AddsOn</li></ol>';
    });

    // Function to generate a color based on the input label
    function getColor(label) {
        // Use a hash function to convert the label to a numerical value
        let hash = 0;
        for (let i = 0; i < label.length; i++) {
            hash = label.charCodeAt(i) + ((hash << 5) - hash);
        }

        // Convert the numerical value to a hexadecimal color code
        const color = "#" + ((hash & 0x00FFFFFF).toString(16)).toUpperCase();

        // Make sure the color is not too light (adjust as needed)
        return color.padEnd(7, "0");
    }
    // Function to create the doughnut chart
    function createDoughnutChart(chartData) {
        // Function to generate colors based on the chart data labels
        function generateColors(labels) {
            const colors = labels.map(label => getColor(label));
            return colors;
        }

        // Data for the doughnut chart
        const data = {
            labels: chartData.labels,
            datasets: [{
                data: chartData.counts,
                backgroundColor: generateColors(chartData.labels),
                hoverBackgroundColor: generateColors(chartData.labels).map(color => adjustColorBrightness(color, -30)),
                borderWidth: 1,
            }]
        };

        // Function to adjust the brightness of a color (same as before)
        function adjustColorBrightness(color, amount) {
            const colorCode = color.slice(1);
            const num = parseInt(colorCode, 16);
            const R = Math.min(255, Math.max(0, (num >> 16) + amount));
            const G = Math.min(255, Math.max(0, ((num >> 8) & 0x00FF) + amount));
            const B = Math.min(255, Math.max(0, (num & 0x0000FF) + amount));
            const newColor = `#${(0x1000000 + (R << 16) + (G << 8) + B).toString(16).slice(1)}`;
            return newColor;
        }

        // Chart options
        const options = {
            responsive: false,
            maintainAspectRatio: false,
            cutoutPercentage: 50,
            legend: {
                display: true,
                position: "bottom",
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 18 // Adjust the font size for legend labels
                        }
                    }
                },
                datalabels: {
                    color: "#fff", // Font color for the labels
                    font: {
                        size: function (context) {
                            // Adjust the font size based on the screen width
                            const width = context.chart.width;
                            return width < 400 ? 10 : 14; // Ternary operator to set font size based on width
                        }
                    }
                }
            }
        };

        // Create the doughnut chart
        const ctx = document.getElementById("roomOccupancyChart").getContext("2d");
        const myDoughnutChart = new Chart(ctx, {
            type: "doughnut",
            data: data,
            options: options
        });
    }

    // Function to create the line chart
    function createLineChart(chartData, timeUnit) {
        // Get the JSON data from PHP and parse it into a JavaScript object
        const trendsData = <?php echo $trendsDataJson; ?>;

        // Access the individual datasets as needed
        const dailyData = trendsData.daily;
        const weeklyData = trendsData.weekly;
        const monthlyData = trendsData.monthly;
        const data = {
            labels: dailyData.dates,
            datasets: [
                {
                    label: 'Daily',
                    data: dailyData.counts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true,
                },
                {
                    label: 'Weekly',
                    data: weeklyData.counts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1,
                    fill: true,
                },
                {
                    label: 'Monthly',
                    data: monthlyData.counts,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1,
                    fill: true,
                }
            ]
        };
        // Chart options
        const options = {
            responsive: false, // Set to true to enable responsiveness
            maintainAspectRatio: false, // Set to false to disable maintaining aspect ratio
            scales: {
                x: {
                    type: 'time', // Use time scale for X-axis
                    time: {
                        unit: timeUnit, // Display unit: 'day', 'week', or 'month'
                        displayFormats: {
                            day: 'MMM d', // Format for daily labels
                            week: 'MMM d', // Format for weekly labels
                            month: 'MMM YYYY', // Format for monthly labels
                        },
                    },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 20, // Limit the number of visible ticks
                    },
                },
                y: {
                    beginAtZero: true,
                    max: 20
                },
            },
        };

        // Create the line chart
        const ctx = document.getElementById("bookingTrendsChart").getContext("2d");
        const myLineChart = new Chart(ctx, {
            type: "line", // Changed the chart type to 'line'
            data: data,
            options: options
        });
    }

    // Inline script to define the data directly in JavaScript
    var chartData = <?php echo $chartData; ?>;
    document.addEventListener("DOMContentLoaded", function () {
        createDoughnutChart(chartData);
    });

    // Call the createLineChart function with the PHP data for each time interval after page load
    document.addEventListener("DOMContentLoaded", function () {
        const dailyData = <?php echo json_encode($dailyData); ?>;
        createLineChart(dailyData, 'day');

        const weeklyData = <?php echo json_encode($weeklyData); ?>;
        createLineChart(weeklyData, 'week');

        const monthlyData = <?php echo json_encode($monthlyData); ?>;
        createLineChart(monthlyData, 'month');
    });
</script>