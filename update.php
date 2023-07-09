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
            header("Location: account.php?userId=" . urlencode($userId) . "&successMessage=" . urlencode($successMessage));
            exit; // Stop further processing
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
                    echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                    value="<?php echo htmlspecialchars($password); ?>" name="password">
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
            <div class="input-group"> <input type="password" id="confirmPassword" class="form-control <?php if (!empty($cPasswordError))
                echo 'is-invalid'; ?>" aria-labelledby="confirmpasswordHelpBlock"
                    value="<?php echo htmlspecialchars($cPassword); ?>" name="cPassword">
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