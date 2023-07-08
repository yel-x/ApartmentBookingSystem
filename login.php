<?php
include 'components/connect.php';

// Retrieve the form data
$emailError = $passwordError = '';
$email = $password = '';
$loginError = '';


if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = "Invalid email format.";
  }

  // Validate password
  if (strlen($password) < 12) {
    $passwordError = "Password must be at least 12 characters long.";
  }

  // If there are no validation errors, proceed with the login operation
  if (empty($emailError) && empty($passwordError)) {
    // Perform the login query
    $sql = "SELECT id FROM userInfo WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Login successful
      $row = $result->fetch_assoc();
      $userId = $row['id'];

      header("Location: index.php?userId=" . urlencode($userId));
      exit; // Stop further execution
    } else {
      // Login failed
      $loginError = "Invalid email or password.";
    }
    $conn->close();
  }
}

require 'components/layout.php';
?>

<title>Log In</title>
</head>

<body>
  <div class="container p-5 my-5 mt-lg-0 d-flex justify-content-center align-items-center vh-100">
    <div class="card mb-3 shadow-lg" style="width: 30rem; height: auto">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/pexels-thorsten-technoman-338504.jpg" class="img-fluid rounded object-fit-cover h-100" />
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title text-center p-3">LOG IN</h5>
            <!-- Display the error message if login failed -->
            <?php if (!empty($loginError)): ?>
              <div class="alert alert-danger">
                <?php echo $loginError; ?>
              </div>
            <?php endif; ?>
            <form action="login.php" method="POST" id="loginForm" novalidate>
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
                <label for="inputPassword5" class="form-label">Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control <?php if (!empty($passwordError))
                  echo 'is-invalid'; ?>" aria-labelledby="passwordHelpBlock"
                  value="<?php echo htmlspecialchars($password); ?>">
                <div class="invalid-feedback">
                  <?php echo $passwordError; ?>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn m-3 btn-outline-danger rounded-5">Log in</button>
              </div>
            </form>
            <div class="p-3">
              Doesn't have an account yet? Register
              <a href="create.php">here</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"></script>
</body>

</html>