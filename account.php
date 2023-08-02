<?php
require 'components/retrieve.php';
require 'components/retrieveRenters.php';
require 'components/layout.php';
require 'components/retrieveRooms.php';

// Check if the current user is a renter and if a title is available
$isRenter = false;
if (isset($title)) {
  foreach ($rented as $renter) {
    if ($renter['email'] == $email && $renter['title'] == $title) {
      $isRenter = true;
      $advancePayment = $renter['advancePayment'];
      break;
    }
  }
}

// Fetch room data based on the rented title
$room = null; // Initialize as null
if ($isRenter && isset($title)) {
  // Create a query to retrieve room information based on the rented title
  $query = "SELECT * FROM rooms WHERE title = '$title'";

  // Execute the query
  $result = mysqli_query($conn, $query);

  // Check if the query was successful
  if ($result) {
    // Fetch the data from the result set and store it in the $room array
    $room = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
  } else {
    echo "Error executing the query: " . mysqli_error($conn);
  }
}

// Calculate the due date one month from the dateMoved
$dateMoved = strtotime($renter['dateMoved']);
$dueDate = date('M d, Y', strtotime('+1 month', $dateMoved));

// Calculate the number of days remaining until the due date
$currentDate = time(); // Current timestamp
$dueDateTimestamp = strtotime($dueDate);
$daysRemaining = floor(($dueDateTimestamp - $currentDate) / (60 * 60 * 24));

// Check if the due date has passed and update the advancePayment
if ($daysRemaining <= 0) {
  $advancePayment -= $room['price'];
  // Update the advancePayment in the rented table
  $updateQuery = "UPDATE rented SET advancePayment = '$advancePayment' WHERE title = '$title'";
  $updateResult = mysqli_query($conn, $updateQuery);
  if (!$updateResult) {
    echo "Error updating the advancePayment: " . mysqli_error($conn);
  }
}
?>

<title>Profile Account</title>
</head>

<body>
  <?php require 'components/navbar.php'; ?>
  <div class="container-md">
    <?php
    if (isset($_GET['successMessage'])) {
      $successMessage = $_GET['successMessage'];
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success updating your account!</strong> ' . $successMessage . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    ?>
    <div class="row row-cols-1 row-cols-md-3 d-flex justify-content-center align-items-center">
      <!-- Card on the left -->
      <?php if ($isRenter && isset($room)): ?>
        <div class="col d-flex flex-column align-items-center p-3 text-center vh-25">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Rent Payment</h5>
              <p class="card-text">
              <h3>Due Date</h3>
              <span class="text-muted">
                <?php echo $dueDate; ?>
              </span>
              <p>
                <?php echo $room['price']; ?>/month
              </p>
              </p>
              <div class="card-footer card-text">
                <h5>
                  <?php echo $daysRemaining; ?> days to due date
                </h5>
                <p>Available payment: <strong>
                    <?php echo $advancePayment; ?>
                  </strong></p>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Name, paragraph, and button in the center -->
      <div class="col d-flex flex-column align-items-center p-3 text-center vh-25">
        <h1 class="pt-5">Welcome
          <?php echo $fName; ?>!
        </h1>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae ex
          quos libero non quasi blanditiis veniam tempore. Eligendi, hic enim.
        </p>
        <button class="btn btn-outline-danger w-50 mt-5 rounded-pill d-none d-md-block">
          Leave us a Review!
        </button>
      </div>

      <!-- Picture on the right -->
      <div class="col d-flex flex-column align-items-center py-5 vh-25">
        <img id="profilePicture" src="<?php echo $pfPicture; ?>" alt="" style="width: 15rem; height: 15rem"
          class="rounded-circle object-fit-cover border border-5 border-danger-subtle" />
        <a href="update.php?userId=<?php echo $userId; ?>"
          class="btn btn-outline-danger w-25 my-3 rounded-pill text-decoration-none">Update</a>
      </div>
    </div>

  </div>
</body>