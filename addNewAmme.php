<?php
require 'components/retrieveAddsOn.php';
session_start();
$errors = array();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize it (add more validation/sanitization as needed)
    $addsOnTitle = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $addsOnTitle = htmlspecialchars($addsOnTitle);
    $description = htmlspecialchars($description);

    // Handle file uploads
    $uploadedFiles = $_FILES['pictures'];
    $fileCount = count($uploadedFiles['name']);
    $picturePaths = array();

    for ($i = 0; $i < $fileCount; $i++) {
        $targetDirectory = "uploads/"; // Set the path where you want to store the uploaded files
        $targetFile = $targetDirectory . basename($uploadedFiles['name'][$i]);

        // Check if the file is valid and move it to the target directory
        if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetFile)) {
            // File uploaded successfully, you can store the file path in the database or process it further.
            // For simplicity, I'll just concatenate the filenames with a separator, you can adjust this as per your database schema.
            $picturePaths[] = $targetFile;
        } else {
            // Error uploading file
            echo "Error uploading file " . $uploadedFiles['name'][$i];
        }
    }
    // Insert data into the database
    $picturePaths = implode("\n", $picturePaths); // Concatenate filenames with a comma (adjust as per your database schema)
    $query = "INSERT INTO addson (title, description, picture, price, availability) VALUES ('$addsOnTitle', '$description', '$picturePaths', '$price', 'Available')";

    if (mysqli_query($conn, $query)) {
        // After successful update
        $userId = $_GET['userId'];
        $successMessage = "addsOn added successfully.";
        $_SESSION['successMessage'] = $successMessage;
        header("Location: admin-dashboard.php?userId={$userId}");
        exit();

    } else {
        // Error inserting data
        $errors[] = "Error: " . mysqli_error($conn);
    }
}
require 'components/navbar.php';
?>
<h2>Add New addsOns</h2>
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
            <label for="validationDefault01" class="form-label">addsOn Title</label>
            <input type="text" class="form-control" name="title" id="validationDefault01" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" id="validationDefault02" required>
        </div>
        <div class="col-md-4">
            <label for="formFileMultiple" class="form-label">Price</label>
            <input class="form-control" type="number" name="price" id="formPrice">
        </div>
        <div class="col-md-8">
            <label for="formFileMultiple" class="form-label">Pictures</label>
            <input class="form-control" type="file" name="pictures[]" id="formFileMultiple" multiple>
        </div>
        <div class="col-12">
            <button class="btn btn-danger" type="submit">Submit form</button>
        </div>
    </form>

</div>