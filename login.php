<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
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
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Email address</label>
              <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" />
            </div>
            <label for="inputPassword5" class="form-label">Password</label>
            <input type="password" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock" />
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn m-3 btn-outline-danger rounded-5">
              <a href="index.html" class="text-decoration-none text-reset">
                Log in</a>
            </button>
          </div>
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