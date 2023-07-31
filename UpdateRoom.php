<?php
require 'components/retrieveRooms.php';
session_start();
$rID = $_GET['rID']; // Get the rID from the URL parameter, adjust this based on your application.
$errors = [];
$updateSuccess = false;

// Find the specific room's data in the $rooms array based on the rID
$roomData = null;
foreach ($rooms as $room) {
    if ($room['rID'] == $rID) {
        $roomData = $room;
        break;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (empty($title)) {
        $errors[] = 'Room Title is required.';
    }
    if (empty($description)) {
        $errors[] = 'Description is required.';
    }
    // Handle File Upload
    if (!empty($_FILES['picture']['name'][0])) {
        $picturePaths = []; // Array to store uploaded picture paths

        // Loop through each uploaded file
        foreach ($_FILES['picture']['tmp_name'] as $key => $tmp_name) {
            $pictureName = $_FILES['picture']['name'][$key];
            $picturePath = "uploads/" . $pictureName;

            // Move the uploaded file to the desired directory
            move_uploaded_file($tmp_name, $picturePath);

            // Add the picture path to the array
            $picturePaths[] = $picturePath;
        }

        // Convert the array of picture paths to a single string
        $serializedPictures = implode(',', $picturePaths);

        // Then update the database along with the other fields
        $updateQuery = "UPDATE rooms SET title = ?, description = ?, picture = ? WHERE rID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $title, $description, $serializedPictures, $rID);
    } else {
        // If no pictures were uploaded, update the database without the picture field
        $updateQuery = "UPDATE rooms SET title = ?, description = ? WHERE rID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssi", $title, $description, $rID);
    }

    if ($stmt->execute()) {
        // After successful update
        $userId = $_GET['userId'];
        $successMessage = "Room updated successfully.";
        $_SESSION['successMessage'] = $successMessage;
        header("Location: admin-dashboard.php?userId={$userId}");
        exit();
    }
    $stmt->close();
}
?>
<?php
require 'components/navbar.php';
?>
<h2>Update rooms</h2>
<div class="container">
    <!-- Display error messages if any -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li>
                        <?php echo $error; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form class="row g-3" method="post" enctype="multipart/form-data">
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">Room Title</label>
            <input type="text" class="form-control" name="title" id="validationDefault01" required
                value="<?php echo isset($roomData['title']) ? htmlspecialchars($roomData['title']) : ''; ?>">
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="validationDefault02" required
                value="<?php echo isset($roomData['description']) ? htmlspecialchars($roomData['description']) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Pictures</label>
            <input class="form-control" type="file" name="picture[]" id="formFileMultiple" multiple>
        </div>
        <div class="col-12">
            <button class="btn btn-danger" type="submit">Submit form</button>
        </div>
    </form>
</div>