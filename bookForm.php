<?php
ob_start(); // Start output buffering
require 'components/retrieveRooms.php';
require 'components/retrieveCopy.php';
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
function executeInsertStatement($conn, $fName, $lName, $email, $title, $date, $addOn)
{
    // Prepare the SQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO appointment (fName, lName, email, title, date, addOn) VALUES (?, ?, ?, ?, ?, ?)");

    // Bind the form values to the prepared statement placeholders
    $stmt->bind_param('ssssss', $fName, $lName, $email, $title, $date, $addOn);

    // Execute the prepared statement to insert the data into the database
    $stmt->execute();
}
require 'components/navbar.php';
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
    }

    // Validate add-ons selection
    $addOn = validateInput($_POST['addOn']);
    if (empty($addOn) || $addOn === '0') {
        $errors['addOn'] = 'Please select a valid add-on.';
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

        // Assuming you have established the $mysqli connection to the database
        // You should always use prepared statements to prevent SQL injection
        executeInsertStatement($conn, $fName, $lName, $email, $title, $date, $addOn);
        // Redirect to the index page after successful insertion
        header("Location: index.php?userId=" . urlencode($userId));
        exit;
    }
}
ob_end_flush();
?>

<title>Book Appointment Form</title>
</head>
<div class="container">
    <form class="row g-3" method="POST">
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

        <div class="col-md-4">
            <label for="validationServeAdd" class="form-label">Select an Adds on</label>
            <select class="form-select <?php echo isset($errors['addOn']) ? 'is-invalid' : ''; ?>"
                aria-label="Default select example" name="addOn">
                <option <?php echo isset($addOn) && $addOn === '0' ? 'selected' : ''; ?> value="0">Open this select menu
                </option>
                <option <?php echo isset($addOn) && $addOn === '1' ? 'selected' : ''; ?> value="1">One</option>
                <option <?php echo isset($addOn) && $addOn === '2' ? 'selected' : ''; ?> value="2">Two</option>
                <option <?php echo isset($addOn) && $addOn === '3' ? 'selected' : ''; ?> value="3">Three</option>
            </select>
            <?php if (isset($errors['addOn'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['addOn']; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Terms and conditions checkbox -->
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input <?php echo isset($errors['terms']) ? 'is-invalid' : ''; ?>"
                    type="checkbox" value="1" id="invalidCheck3" name="terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="invalidCheck3">
                    Agree to terms and conditions
                </label>
                <?php if (isset($errors['terms'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $errors['terms']; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submit button -->
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Appoint</button>
        </div>
    </form>
</div>