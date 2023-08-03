<?php
session_start();
require 'components/retrieve.php';
require 'components/retrieveRenters.php';
$fNameError = $lNameError = $emailError = $passwordError = $cPasswordError = $pfPictureError = '';
$errorMessage = ''; // Initialize error message variable

if (isset($_POST['submit']) || isset($_POST['userId'])) {
    $userId = $_GET['userId'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cPassword = $_POST['cPassword'];

    // Validate first name
    if (empty($fName)) {
        $fNameError = 'First name is required.';
    } elseif (!preg_match('/^[a-zA-Z]+$/', $fName)) {
        $fNameError = 'First name should only contain letters.';
    }

    // Validate last name
    if (empty($lName)) {
        $lNameError = 'Last name is required.';
    } elseif (!preg_match('/^[a-zA-Z]+$/', $lName)) {
        $lNameError = 'Last name should only contain letters.';
    }

    // Validate email
    if (empty($email)) {
        $emailError = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Invalid email format.';
    }

    // Validate profile picture
    if ($_FILES['pfPicture']['error'] === UPLOAD_ERR_OK) {
        $maxFileSize = 20 * 1024 * 1024; // 20MB in bytes
        $uploadDir = "uploads/";
        $uploadFile = $uploadDir . basename($_FILES['pfPicture']['name']);

        // Check if the uploaded file is an image
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedImageTypes = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedImageTypes)) {
            $errorMessage = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        } elseif ($_FILES['pfPicture']['size'] > $maxFileSize) {
            $errorMessage = "File size exceeds the maximum allowed (20MB).";
        } else {
            if (move_uploaded_file($_FILES['pfPicture']['tmp_name'], $uploadFile)) {
                $newPicture = $uploadFile;
                var_dump($newPicture);

                // Retrieve the old profile picture path for the user from the database
                $sql = "SELECT pfPicture FROM userInfo WHERE id = $userId";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $oldPicture = $row['pfPicture'];

                    // Update the profile picture path in the userInfo table
                    $updateSql = "UPDATE userInfo SET pfPicture = '$newPicture' WHERE id = $userId";
                    $updateResult = mysqli_query($conn, $updateSql);

                    if ($updateResult) {
                        // Delete the old picture file
                        if ($oldPicture !== "path/to/old/picture.jpg") {
                            unlink($oldPicture);
                        }
                    } else {
                        $errorMessage = "An error occurred while updating the profile picture in the userInfo table.";
                        error_log("Query Error: " . mysqli_error($conn));
                    }
                } else {
                    // Initialize $oldPicture with some default value if profile picture update is not performed
                    $oldPicture = "path/to/old/picture.jpg";
                }

                // Now update the profile picture path in the rented table
                $sql1 = "UPDATE rented SET pfPicture = '$newPicture' WHERE id = $userId";
                $updateResult1 = mysqli_query($conn, $sql1);

                if (!$updateResult1) {
                    $errorMessage .= " An error occurred while updating the profile picture in the rented table.";
                    error_log("Query Error: " . mysqli_error($conn));
                }
            } else {
                $errorMessage = "An error occurred while uploading the profile picture.";
            }
        }
    }

    // If there are no validation errors for non-password fields, update the user information
    if (empty($fNameError) && empty($lNameError) && empty($emailError)) {
        // Validate password if provided
        if (!empty($password) || !empty($cPassword)) {
            // Validate password length
            if (strlen($password) < 12) {
                $passwordError = 'Password should have at least 12 characters.';
            }

            // Validate confirm password
            if ($password !== $cPassword) {
                $cPasswordError = 'Passwords do not match.';
            }
        }

        // If there are no password validation errors, update the user information
        if (empty($passwordError) && empty($cPasswordError)) {
            // Update non-password fields in the userInfo table
            $updateSqlUserInfo = "UPDATE userInfo SET fName='$fName', lName='$lName', email='$email' WHERE id=$userId";
            $resultUserInfo = mysqli_query($conn, $updateSqlUserInfo);

            // Update non-password fields in the rented table
            $updateSqlRented = "UPDATE rented SET fName='$fName', lName='$lName', email='$email' WHERE id=$userId";
            $resultRented = mysqli_query($conn, $updateSqlRented);

            // Handle password updates if both passwords are provided
            if (!empty($password) && !empty($cPassword)) {
                // Hash the passwords before updating in the database
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $hashedCPassword = password_hash($cPassword, PASSWORD_BCRYPT);

                // Use a separate query to update password fields
                $updatePasswordSql = "UPDATE userInfo SET password='$hashedPassword', cPassword='$hashedCPassword' WHERE id=$userId";
                $resultPassword = mysqli_query($conn, $updatePasswordSql);

                // Use a separate query to update password fields
                $updatePasswordSql = "UPDATE rented SET password='$hashedPassword', cPassword='$hashedCPassword' WHERE id=$userId";
                $resultPassword = mysqli_query($conn, $updatePasswordSql);

                if (!$resultPassword) {
                    // Handle password update failure
                    $errorMessage = "An error occurred while updating the password.";
                    error_log("Query Error: " . mysqli_error($conn));
                }
            }

            // Redirect to success page if non-password fields were successfully updated
            if ($resultUserInfo && $resultRented) {
                $_SESSION['successMessage'] = 'Succesfully updated your account';
                // Redirect back to account.php with only the userId in the URL
                $redirectUrl = 'account.php?userId=' . urlencode($userId);
                header("Location: " . $redirectUrl);
                exit;
            }
        }
    }

}
?>
<?php
require 'components/navbar.php';
?>
<title>Update Profile</title>
</head>

<div class="container-lg my-3 my-md-5 col-10 col-md-6 shadow p-3 p-md-5 rounded-3 rounded-md-5">
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <h5 class="card-title text-center p-3  mb-3">Updating userID no.
            <strong class="fw-bold text-decoration-underline">
                <?php echo $userId ?>
            </strong>
        </h5>
        <div class="form-group mb-3">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control <?php if (!empty($fNameError))
                echo 'is-invalid'; ?>" placeholder="Enter your first name" name="fName" autocomplete="off"
                value="<?php echo htmlspecialchars($fName); ?>">
            <?php if (!empty($fNameError)): ?>
                <div class="invalid-feedback">
                    <?php echo $fNameError; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control <?php if (!empty($lNameError))
                echo 'is-invalid'; ?>" placeholder="Enter your last name" name="lName" autocomplete="off"
                value="<?php echo htmlspecialchars($lName); ?>">
            <?php if (!empty($lNameError)): ?>
                <div class="invalid-feedback">
                    <?php echo $lNameError; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group mb-3">
            <label for="formFile" class="form-label">Upload your picture</label>
            <input class="form-control <?php if (!empty($pfPictureError))
                echo 'is-invalid'; ?>" type="file" id="pfPicture" name="pfPicture">
            <small class="text-muted">*Only picture 20mb and below is accepted</small>
            <?php if (!empty($pfPictureError)): ?>
                <div class="invalid-feedback">
                    <?php echo $pfPictureError; ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($errorMessage)): ?>
                <div class="invalid-feedback">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="form-group mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control <?php if (!empty($emailError))
                echo 'is-invalid'; ?>" placeholder="Enter your email" name="email" autocomplete="off"
                value="<?php echo htmlspecialchars($email); ?>">
            <?php if (!empty($emailError)): ?>
                <div class="invalid-feedback">
                    <?php echo $emailError; ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- password update -->
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <div class="input-group">
                <input type="password" id="inputPassword" class="form-control <?php if (!empty($passwordError))
                    echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock" name="password">
                <!-- close eye -->
                <span class="input-group-text rounded-end toggle-icon" id="togglePassword"
                    onclick="togglePasswordVisibility()">
                    <i id="toggleIcon" class="fas fa-eye-slash"></i>
                </span>
                <?php if (!empty($passwordError)): ?>
                    <div class="invalid-feedback">
                        <?php echo $passwordError; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- cPassword update -->
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <div class="input-group">
                <input type="password" id="confirmPassword" class="form-control <?php if (!empty($cPasswordError))
                    echo 'is-invalid'; ?>" aria-labelledby="confirmpasswordHelpBlock" name="cPassword">
                <!-- open eye -->
                <span class="input-group-text rounded-end toggle-icon" id="togglePassword" onclick="toggleCPass()">
                    <i id="toggleIconCPass" class="fas fa-eye-slash"></i>
                </span>
                <?php if (!empty($cPasswordError)): ?>
                    <div class="invalid-feedback">
                        <?php echo $cPasswordError; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-5">
            <button type="button" class="btn btn-secondary btn-sm me-3 p-2 rounded-pill">
                <a href="account.php?userId=<?php echo $userId; ?>" class="text-white text-decoration-none">Cancel</a>
            </button>
            <button type="submit" class="btn btn-outline-danger rounded-pill" name="submit">Update</button>
        </div>
    </form>
</div>

<script> function togglePasswordVisibility() {
        var passwordInput = document.getElementById("inputPassword");
        var toggleIcon = document.getElementById("toggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
    function toggleCPass() {
        var passwordInput = document.getElementById("confirmPassword");
        var toggleIcon = document.getElementById("toggleIconCPass");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>