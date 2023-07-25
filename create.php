<?php
include 'components/connect.php';
// Retrieve form data
$firstNameError = $emailError = $lastNameError = $pfPictureError = $passwordError = $cPasswordError = '';
$firstName = $email = $lastName = $pfPicture = $password = $cPassword = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstName = $_POST['firstName'];
  $email = $_POST['email'];
  $pfPicture = $_FILES['pfPicture'];
  $lastName = $_POST['lastName'];
  $password = $_POST['password'];
  $cPassword = $_POST['cPassword'];

  // Validate first name
  if (!preg_match('/^[A-Z][a-zA-Z]*$/', $firstName)) {
    $firstNameError = "First name should only contain letters.";
  }

  // Validate last name
  if (!preg_match('/^[A-Z][a-zA-Z]*$/', $lastName)) {
    $lastNameError = "Last name should only contain letters.";
  }

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = "Invalid email format.";
  }
  // Check if email already exists in the database
  $existingEmailQuery = "SELECT COUNT(*) FROM `userInfo` WHERE email = '$email'";
  $existingEmailResult = mysqli_query($conn, $existingEmailQuery);
  $existingEmailCount = mysqli_fetch_row($existingEmailResult)[0];

  if ($existingEmailCount > 0) {
    $emailError = "Email already exists.";
  }

  // Validate profile picture
  if ($_FILES['pfPicture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/"; // Directory to store uploaded images
    $uploadFile = $uploadDir . basename($_FILES['pfPicture']['name']);

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($_FILES['pfPicture']['tmp_name'], $uploadFile)) {
      $pfPicture = $uploadFile;
    }
  } else {
    $pfPictureError = "There's no profile picture.";
  }

  // Validate password
  if (strlen($password) < 12) {
    $passwordError = "Password must be at least 12 characters long.";
  }

  // Validate confirm password
  if ($password !== $cPassword) {
    $cPasswordError = "Passwords do not match.";
  }

  // If there are no validation errors, proceed with the insert operation
  if (empty($firstNameError) && empty($emailError) && empty($lastNameError) && empty($pfPictureError) && empty($passwordError) && empty($cPasswordError)) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `userInfo` (fName, email, lName, pfPicture, password, cPassword) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstName, $email, $lastName, $pfPicture, $hashedPassword, $hashedPassword);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
      header('location: login.php');
      exit; // Stop further execution
    } else {
      die(mysqli_error($conn));
    }
  }
}
?>


<?php
require 'components/navbar.php';
?>
<style>
  .toggle-icon {
    cursor: pointer;
  }
</style>
<title>Register</title>
</head>

<body>
  <div class="container my-3 mt-lg-4 d-flex flex-row-reverse justify-content-center align-items-center">
    <div class="card shadow-lg" style="max-width: 50rem; height: auto">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/pexels-thorsten-technoman-338504.jpg"
            class="img-fluid rounded-start object-fit-cover h-100 d-none d-md-block" />
        </div>
        <div class="col-12 col-md-8">
          <!-- form -->
          <form action="create.php" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="card-body">
              <h5 class="card-title text-center p-3">Register Here!</h5>
              <div class="mb-3">
                <label for="firstName" class="form-label">First name:</label>
                <input type="text" class="form-control <?php if (!empty($firstNameError))
                  echo 'is-invalid'; ?>" id="firstName" name="firstName" placeholder="Jose" required
                  value="<?php echo htmlspecialchars($firstName); ?>">
                <div class="invalid-feedback">
                  <?php echo $firstNameError; ?>
                </div>
              </div>
              <div class="mb-3">
                <label for="lastName" class="form-label">Last name:</label>
                <input type="text" class="form-control <?php if (!empty($lastNameError))
                  echo 'is-invalid'; ?>" id="lastName" name="lastName" placeholder="Rizal" required
                  value="<?php echo htmlspecialchars($lastName); ?>">
                <div class="invalid-feedback">
                  <?php echo $lastNameError; ?>
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" class="form-control <?php if (!empty($emailError))
                  echo 'is-invalid'; ?>" id="email" name="email" placeholder="joserizal@gmail.com" required
                  value="<?php echo htmlspecialchars($email); ?>">
                <div class="invalid-feedback">
                  <?php echo $emailError; ?>
                </div>
              </div>
              <div class="mb-3">
                <label for="formFile" class="form-label">Upload your picture</label>
                <input class="form-control <?php if (!empty($pfPictureError))
                  echo 'is-invalid'; ?>" type="file" id="pfPicture" name="pfPicture">
                <?php if (!empty($pfPictureError)): ?>
                  <div class="invalid-feedback">
                    <?php echo $pfPictureError; ?>
                  </div>
                <?php endif; ?>
              </div>
              <!-- password field -->
              <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <div class="input-group">
                  <input type="password" id="passwordInput" name="password" class="form-control <?php if (!empty($passwordError))
                    echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                    value="<?php echo htmlspecialchars($password); ?>">
                  <!-- close eye -->
                  <span class="input-group-text rounded-end toggle-icon" id="togglePassword"
                    onclick="togglePasswordVisibility()">
                    <i id="toggleIcon" class="fas fa-eye-slash"></i>
                  </span>
                  <div class="invalid-feedback">
                    <?php echo $passwordError; ?>
                  </div>
                </div>
              </div>
              <!-- confirm password input -->
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <div class="input-group">
                  <input type="password" id="confirmPassword" name="cPassword" class="form-control <?php if (!empty($cPasswordError))
                    echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                    value="<?php echo htmlspecialchars($cPassword); ?>">
                  <!-- open eye -->
                  <span class="input-group-text rounded-end toggle-icon" id="togglePassword" onclick="toggleCPass()">
                    <i id="toggleIconCPass" class="fas fa-eye-slash"></i>
                  </span>
                  <div class="invalid-feedback">
                    <?php echo $cPasswordError; ?>
                  </div>

                </div>
              </div>
              <div class="d-flex justify-content-end align-items-center">
                <button type=" submit" name="submit" class="btn m-3 btn-outline-danger rounded-5">
                  Submit
                </button>
              </div>
            </div>
            <div class="ms-3 mb-3">
              Already have an account? Login
              <a href="login.php">here</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("passwordInput");
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