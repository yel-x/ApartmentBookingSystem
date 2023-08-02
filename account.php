<?php
require 'components/retrieve.php';
require 'components/retrieveRenters.php';
require 'components/layout.php';
?>

<title>Profile Account</title>
</head>

<body>
  <?php require 'components/navbar.php'; ?>
  <div class="container-md">
    <?php
    if (isset($_GET['successMessage'])) {
      $successMessage = $_GET['successMessage'];
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success updating your account!</strong> ' . $successMessage . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    ?>
    <div class="row row-cols-1 row-cols-md-3 d-flex justify-content-center align-items-center">
      <!-- Card on the left -->
      <div class="col d-flex flex-column align-items-center p-3 text-center vh-25">
        <div class="card" style="width: 18rem;">
          <div class="card-body">
            <h5 class="card-title">Rent Payment</h5>
            <p class="card-text">
            <h3>Due Date</h3>
            <span class="text-muted">Aug 5, 2023</span>
            <p>3000.00</p>
            </p>
            <div class="card-footer card-text">
              <h5>5 days to due date</h5>
              <p>Available payment: <strong>
                  <?php echo $advancePayment; ?>
                </strong></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Name, paragraph, and button in the center -->
      <div class="col d-flex flex-column align-items-center p-3 text-center vh-25">
        <h1 class="pt-5">Welcome
          <?php echo $fName; ?>!
        </h1>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae ex
          quos libero non quasi blanditiis veniam tempore. Eligendi, hic enim.
        </p>
        <button class="btn btn-outline-danger w-50 mt-5 rounded-pill d-none d-md-block">
          Leave us a Review!
        </button>
      </div>

      <!-- Picture on the right -->
      <div class="col d-flex flex-column align-items-center py-5 vh-25">
        <img id="profilePicture" src="<?php echo $pfPicture; ?>" alt="" style="width: 15rem; height: 15rem"
          class="rounded-circle object-fit-cover border border-5 border-danger-subtle" />
        <a href="update.php?userId=<?php echo $userId; ?>"
          class="btn btn-outline-danger w-25 my-3 rounded-pill text-decoration-none">Update</a>
      </div>
    </div>

  </div>
  <script>

  </script>
</body>