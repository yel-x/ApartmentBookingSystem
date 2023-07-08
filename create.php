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
    $sql = "INSERT INTO `userInfo` (fName, email, lName, pfPicture, password, cPassword) VALUES ('$firstName', '$email', '$lastName','$pfPicture', '$password', '$cPassword')";
    $result = mysqli_query($conn, $sql);
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
require 'components/layout.php';
?>
<title>Register</title>
</head>

<body class="p-5 mt-3 mb-5">
  <div class="container mt-5 d-flex flex-row-reverse justify-content-center align-items-center vh-100">
    <div class="card mb-3 shadow-lg" style="width: 800px; height: auto">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/pexels-thorsten-technoman-338504.jpg"
            class="img-fluid rounded object-fit-cover h-100 d-none d-md-block" />
        </div>
        <div class="col-md-8">
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
              <div class="mb-3">
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control <?php if (!empty($passwordError))
                  echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                  value="<?php echo htmlspecialchars($password); ?>">
                <div class="invalid-feedback">
                  <?php echo $passwordError; ?>
                </div>
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" id="confirmPassword" name="cPassword" class="form-control <?php if (!empty($cPasswordError))
                  echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                  value="<?php echo htmlspecialchars($cPassword); ?>">
                <div class="invalid-feedback">
                  <?php echo $cPasswordError; ?>
                </div>
              </div>


              <div class="d-flex justify-content-end">
                <button type="submit" name="submit" class="btn m-3 btn-outline-danger rounded-5">
                  Submit
                </button>
              </div>
            </div>
            <div class="ms-3 mb-3">
              Aready have an account? Login
              <a href="login.php">here</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>