<?php
ob_start(); // Start output buffering
require 'components/layout.php';
require 'components/retrieveRooms.php';
require 'components/retrieveCopy.php';
require 'components/retrieveAddsOn.php';
require 'components/retrieveAppointment.php';
// Initialize form data and errors
$errors = array();
$fName = $lName = $email = $date = $addOn = '';
$fNameError = $lNameError = $emailError = $dateError = $addOnError = '';

// Check if userId exists in the URL
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
}

// Function to validate input fields
function validateInput($input)
{
    return trim(htmlspecialchars($input));
}

// Function to execute the SQL INSERT statement
function executeInsertStatement($conn, $fName, $lName, $email, $title, $date, $selectedAddons)
{
    // Prepare the SQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO appointment (fName, lName, email, title, date, addOn) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind the form values to the prepared statement placeholders
    $stmt->bind_param('ssssss', $fName, $lName, $email, $title, $date, $selectedAddons);

    // Execute the prepared statement to insert the data into the database
    $stmt->execute();
}
require 'components/navbar.php';

// Function to check if the user has already booked the room
function hasUserBookedRoom($conn, $email, $title)
{
    // Initialize $count to 0
    $count = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM appointment WHERE email = ? AND title = ?");
    $stmt->bind_param('ss', $email, $title);
    $stmt->execute();
    $stmt->bind_result($count);

    $stmt->fetch();
    $stmt->close();

    return ($count > 0);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate first name
    $fName = validateInput($_POST['fName']);
    if (empty($fName)) {
        $errors['fName'] = 'Please enter your first name.';
    }

    // Validate last name
    $lName = validateInput($_POST['lName']);
    if (empty($lName)) {
        $errors['lName'] = 'Please enter your last name.';
    }

    // Validate email
    $email = validateInput($_POST['email']);
    if (empty($email)) {
        $errors['email'] = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }

    // Validate date
    $date = validateInput($_POST['date']);
    if (empty($date) || $date === '0') {
        $errors['date'] = 'Please select a valid date.';
    } else {
        // Convert the selected date to a timestamp
        $selectedTimestamp = strtotime($date);
        // Get the current timestamp
        $currentTimestamp = time();

        // Check if the selected date is in the past
        if ($selectedTimestamp < $currentTimestamp) {
            $errors['date'] = 'You cannot select a past date.';
        }
    }

    // Validate terms and conditions checkbox
    $termsChecked = isset($_POST['terms']) && $_POST['terms'] === '1';
    if (!$termsChecked) {
        $errors['terms'] = 'You must agree to the terms and conditions.';
    }

    // If the form is submitted and there are no validation errors
    if (empty($errors)) {
        // Get the rID from the URL using $_GET
        $rID = $_GET['rID'];
        if (hasUserBookedRoom($conn, $email, $title)) {
            $errors['general'] = 'You have already booked a room.';
        } else {
            // Placeholder function to retrieve the title based on the rID
            function getTitleForRoom($roomId, $roomsData)
            {
                foreach ($roomsData as $room) {
                    if ($room['rID'] === $roomId) {
                        return $room['title'];
                    }
                }
                // Return default title if the rID doesn't match any rooms
                return "Default Title";
            }

            // Call the function to retrieve the title for the given rID
            $title = getTitleForRoom($rID, $rooms);
            // Convert the selected addons array to a comma-separated string
            $selectedAddonsStr = implode(", ", $selectedAddons);

            // Call the modified function to execute the SQL INSERT statement
            executeInsertStatement($conn, $fName, $lName, $email, $title, $date, $selectedAddonsStr);

            // Set a success message in a session variable
            $_SESSION['successMessage'] = 'Data successfully inserted.';
            // Redirect to the index page after successful insertion
            header("Location: index.php?userId=" . urlencode($userId));
            exit;
        }
    }
}
ob_end_flush();
?>

<title>Book Appointment Form</title>
</head>
<div class="container">
    <form class="row m-3" method="POST">
        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errors['general']; ?>
            </div>
        <?php endif; ?>
        <!-- First name field -->
        <div class="col-md-4">
            <label for="validationServer01" class="form-label">First name</label>
            <input type="text" class="form-control <?php echo isset($errors['fName']) ? 'is-invalid' : ''; ?>"
                id="validationServer01" name="fName" value="<?php echo isset($fName) ? $fName : ''; ?>">
            <?php if (isset($errors['fName'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['fName']; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Last name field -->
        <div class="col-md-4">
            <label for="validationServer02" class="form-label">Last name</label>
            <input type="text" class="form-control <?php echo isset($errors['lName']) ? 'is-invalid' : ''; ?>"
                id="validationServer02" name="lName" value="<?php echo isset($lName) ? $lName : ''; ?>">
            <?php if (isset($errors['lName'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['lName']; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Email field -->
        <div class="col-md-4">
            <label for="validationServerUsername" class="form-label">Email</label>
            <div class="input-group has-validation">
                <input type="text" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>"
                    id="validationServerUsername" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback"
                    name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['email']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Display picture and title -->
        <?php if (isset($_GET['rID'])): ?>

            <?php
            // Get the rID from the URL using $_GET
            $rID = $_GET['rID'];

            // Placeholder function to retrieve the picture URL and title based on the rID
            function getPictureAndTitleForRoom($roomId, $roomsData)
            {
                foreach ($roomsData as $room) {
                    if ($room['rID'] === $roomId) {
                        // Check if the room has any pictures
                        if (isset($room['picture']) && !empty(trim($room['picture']))) {
                            // Split the picture URLs into an array using line breaks as delimiters
                            $pictureUrls = explode("\n", $room['picture']);
                            // Take the first URL from the array
                            $firstPictureUrl = isset($pictureUrls[0]) ? trim($pictureUrls[0]) : null;

                            // Return both the picture URL and the title as an array
                            return [
                                'picture' => $firstPictureUrl,
                                'title' => $room['title']
                            ];
                        }
                    }
                }
                // Return default values for picture and title if the rID doesn't match any rooms or there are no pictures
                return [
                    'picture' => "path/to/default-image.jpg",
                    'title' => "Default Title"
                ];
            }

            // Call the function to retrieve the picture URL and title for the given rID
            $roomData = getPictureAndTitleForRoom($rID, $rooms);

            // Extract the picture URL and title from the returned array
            $pictureUrl = $roomData['picture'];
            $title = $roomData['title'];
            ?>

            <div class="col-md-4">
                <label class="form-label">
                    <?php echo $title; ?>
                </label>
                <img src="<?php echo $pictureUrl; ?>" alt="Room Picture" class="img-fluid rounded rounded-3 shadow">
            </div>
        <?php endif; ?>
        <!-- Date field -->
        <div class="col-md-4">
            <label for="validationServeDate" class="form-label">Date</label>
            <div class="input-group has-validation">
                <input type="date" class="form-control <?php echo isset($errors['date']) ? 'is-invalid' : ''; ?>"
                    id="validationServeDate" aria-describedby="inputGroupPrepend3 validationServeDateFeedback"
                    name="date" value="<?php echo isset($date) ? $date : ''; ?>">
                <?php if (isset($errors['date'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['date']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Checkboxes for addsons -->
        <div class="col-md-4">
            <label class="form-label">Select Addons</label><br>
            <?php
            // Filter the $addsons array to keep only those with "In-Stock" or "Available" availability
            $filteredAddsons = array_filter($addsons, function ($addson) {
                $availability = $addson['availability'];
                return $availability === 'In-Stock' || $availability === 'Available';
            });

            // Display the filtered addsons using the $filteredAddsons array
            foreach ($filteredAddsons as $addson):
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="addons[]" id="addon-<?php echo $addson['id']; ?>"
                        value="<?php echo $addson['title']; ?>">
                    <label class="form-check-label" for="addon-<?php echo $addson['id']; ?>">
                        <?php echo htmlspecialchars($addson['title']); ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <?php if (isset($errors['addons'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['addons']; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Terms and conditions checkbox and trigger for the modal -->
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input <?php echo isset($errors['terms']) ? 'is-invalid' : ''; ?>"
                    type="checkbox" value="1" id="invalidCheck3" name="terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="invalidCheck3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Agree to terms and conditions</a>
                </label>
                <?php if (isset($errors['terms'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['terms']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Bootstrap Modal for terms and conditions -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="termsModal">Terms and Condition</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php require 'terms_modal_content.php'; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit button -->
        <div class="col-12 mt-2">
            <button class="btn btn-primary" type="submit">Appoint</button>
        </div>
    </form>
</div>