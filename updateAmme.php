<?php
require 'components/retrieveAddsOn.php';
session_start();
$id = $_GET['id']; // Get the id from the URL parameter, adjust this based on your application.
$errors = [];
$updateSuccess = false;

// Find the specific addson's data in the $addsons array based on the id
$addsonData = null;
foreach ($addsons as $addson) {
    if ($addson['id'] == $id) {
        $addsonData = $addson;
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];

    if (empty($title)) {
        $errors[] = 'addson Title is required.';
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
        $updateQuery = "UPDATE addson SET title = ?, description = ?, picture = ?, availability = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssssii", $title, $description, $serializedPictures, $availability, $price, $id);
    } else {
        // If no pictures were uploaded, update the database without the picture field
        $updateQuery = "UPDATE addson SET title = ?, description = ?, availability = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssii", $title, $description, $availability, $price, $id);
    }
    if ($stmt->execute()) {
        // After successful update
        $userId = $_GET['userId'];
        $successMessage = "Ammenity updated successfully.";
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
<h2>Update addsons</h2>
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
            <label for="validationDefault01" class="form-label">Ammenity Title</label>
            <input type="text" class="form-control" name="title" id="validationDefault01" required
                value="<?php echo isset($addsonData['title']) ? htmlspecialchars($addsonData['title']) : ''; ?>">
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="validationDefault02" required
                value="<?php echo isset($addsonData['description']) ? htmlspecialchars($addsonData['description']) : ''; ?>">
        </div>
        <div class="col-md-4">
            <label for="formPrice" class="form-label">Price</label>
            <input class="form-control" type="number" name="price" id="formPrice" required
                value="<?php echo isset($addsonData['price']) ? htmlspecialchars($addsonData['price']) : ''; ?>">
        </div>
        <div class="col-md-4">
            <label>availability</label><br>
            <input type="radio" name="availability" id="availability-available" value="Available" <?php echo $addsonData['availability'] === 'Available' ? 'checked' : ''; ?>>
            <label for="availability-available">Available</label><br>
            <input type="radio" id="availability-Sold" name="availability" value="Sold" <?php echo $addsonData['availability'] === 'Sold' ? 'checked' : ''; ?>>
            <label for="availability-Sold">Sold</label><br>
            <input type="radio" id="availability-In-Stock" name="availability" value="In-Stock" <?php echo $addsonData['availability'] === 'In-Stock' ? 'checked' : ''; ?>>
            <label for="availability-In-Stock">In-Stock</label>
        </div>
        <div class="col-md-8">
            <label for="formFileMultiple" class="form-label">Pictures</label>
            <input class="form-control" type="file" name="picture[]" id="formFileMultiple" multiple>
        </div>
        <div class="col-12">
            <button class="btn btn-danger" type="submit">Submit form</button>
        </div>
    </form>
</div>