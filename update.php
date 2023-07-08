<?php
include 'components/retrieve.php';

$fNameError = $lNameError = $emailError = $passwordError = $cPasswordError = '';
// = $pfPictureError
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

    // Validate password
    if (strlen($password) < 12) {
        $passwordError = 'Password should have at least 12 characters.';
    }

    // Validate confirm password
    if ($password !== $cPassword) {
        $cPasswordError = 'Passwords do not match.';
    }

    // If there are no validation errors, update the user information
    if (empty($fNameError) && empty($lNameError) && empty($emailError) && empty($passwordError) && empty($cPasswordError)) {
        $sql = "UPDATE `userInfo` SET fName='$fName', lName='$lName', email='$email', password='$password', cPassword='$cPassword' WHERE id=$userId";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            header("Location: account.php?userId=" . urlencode($userId));
            exit; // Stop further processing
        }
    }
}

?>

<?php
require 'components/layout.php';
?>

<body>
    <div class="container my-5 col-sm-9 col-lg-6">
        <form method="post" enctype="multipart/form-data">
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
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" id="inputPassword" class="form-control <?php if (!empty($passwordError))
                    echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                    value="<?php echo htmlspecialchars($password); ?>" name="password">
                <?php if (!empty($passwordError)): ?>
                    <div class="invalid-feedback">
                        <?php echo $passwordError; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" id="confirmPassword" class="form-control <?php if (!empty($cPasswordError))
                    echo 'is-invalid'; ?>" aria-labelledby="confirmpasswordHelpBlock"
                    value="<?php echo htmlspecialchars($cPassword); ?>" name="cPassword">
                <?php if (!empty($cPasswordError)): ?>
                    <div class="invalid-feedback">
                        <?php echo $cPasswordError; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end align-items-center mt-5">
                <button type="button" class="btn btn-secondary btn-sm me-3">
                    <a href="account.php?userId=<?php echo $userId; ?>"
                        class="text-white text-decoration-none">Cancel</a>
                </button>
                <button type="submit" class="btn btn-success" name="submit">Update</button>
            </div>
        </form>
    </div>
</body>