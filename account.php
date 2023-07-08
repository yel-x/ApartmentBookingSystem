<?php
require 'components/retrieve.php';
require 'components/layout.php';

?>

<title>Profile Account</title>
</head>

<body>
  <?php require 'components/navbar.php'; ?>
  <div class="container-md">
    <div class="row row-cols-1 row-cols-sm-2 d-flex justify-content-center align-items-center ">
      <div class="col  d-flex flex-column align-items-center p-3 p-lg-5 text-center vh-25">
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
      <div class="col d-flex flex-column align-items-center py-5 vh-25">
        <form action="" method="POST" enctype="multipart/form-data">
          <img id="profilePicture" src="<?php echo $pfPicture; ?>" alt="" style="width: 15rem; height: 15rem"
            class="rounded-circle object-fit-cover border border-5 border-danger-subtle" onclick="selectImage()" />
          <input type="file" name="pfPicture" id="imageUpload" style="display: none" accept="image/*" />
        </form>
        <a href="update.php?userId=<?php echo $userId; ?>"
          class="btn btn-outline-danger w-25 my-3 rounded-pill text-decoration-none">Update</a>
      </div>
    </div>
  </div>
  <script>

  </script>
</body>