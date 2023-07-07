<?php
require 'retrieve.php';

// Retrieve the user ID from the query parameter
$userId = $_GET['id']; // Replace this with the actual query parameter name

// Retrieve the user's profile picture based on the user ID
$query = "SELECT pfPicture FROM userInfo WHERE id = $userId";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $profilePicture = $row['pfPicture'];
} else {
  // Default profile picture or error handling
  $profilePicture = "default-profile-picture.jpg";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
  <title>Profile Account</title>
</head>

<body>
  <?php require 'components/navbar.php'; ?>
  <div class="container">
    <div class="d-flex row justify-content-center">
      <div class="col col-8 col-lg-7 px-3 d-flex flex-column align-items-center pt-5 text-center">
        <h1 class="pt-5">Welcome
          <?php echo $fName; ?>!
        </h1>
        <p>
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Beatae ex
          quos libero non quasi blanditiis veniam tempore. Eligendi, hic enim.
        </p>
        <button class="btn btn-outline-danger w-50 mt-5 rounded-pill">
          Leave us a Review!
        </button>
      </div>
      <div class="col col-8 col-lg-5 d-flex flex-column align-items-center py-5">
        <img src="<?php echo $profilePicture; ?>" alt="" style="width: 15rem; height: 15rem"
          class="rounded-circle object-fit-cover border border-5 border-danger-subtle" />

        <button class="btn btn-outline-danger w-25 my-3 rounded-pill">
          Update
        </button>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>