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

require 'components/navbar.php';
?>

<title>Log In</title>
</head>


<body>
  <div class="container pt-4 pt-lg-0 d-flex justify-content-center align-items-center mt-0 mt-lg-5">
    <div class="card shadow-lg " style="max-width: 30rem; height: auto">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="assets/pexels-thorsten-technoman-338504.jpg"
            class="img-fluid rounded-start object-fit-cover h-100 d-none d-md-block" />
        </div>
        <div class="col-12 col-md-8">
          <div class="card-body">
            <h5 class="card-title text-center p-lg-3">LOG IN</h5>
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
                <div class="input-group">
                  <input type="password" id="inputPassword" name="password" class="form-control <?php if (!empty($passwordError))
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
                  <div class="invalid-feedback">
                    <?php echo $passwordError; ?>
                  </div>
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
    <script>
      function togglePasswordVisibility() {
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
    </script>