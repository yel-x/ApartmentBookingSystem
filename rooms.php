<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <style></style>
    <title>Room details</title>
  </head>
  <body>
    <div class="container-md">
      <div class="d-flex flex-lg-row flex-column mt-5">
        <!-- carousel image -->
        <div
          id="carouselExampleIndicators"
          class="carousel slide carousel-dark carousel-fade rounded rounded-circle"
        >
          <div class="carousel-indicators">
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="0"
              class="active"
              aria-current="true"
              aria-label="Slide 1"
            ></button>
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="1"
              aria-label="Slide 2"
            ></button>
            <button
              type="button"
              data-bs-target="#carouselExampleIndicators"
              data-bs-slide-to="2"
              aria-label="Slide 3"
            ></button>
          </div>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                class="d-block w-100"
                alt="..."
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                class="d-block w-100"
                alt="..."
              />
            </div>
            <div class="carousel-item">
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                class="d-block w-100"
                alt="..."
              />
            </div>
          </div>
          <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev"
          >
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next"
          >
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        <!-- infos -->
        <div class="d-flex flex-column mx-5 align-self-center">
          <h1>Room 1</h1>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, sed.
            Repudiandae repellendus, ab dicta natus similique sunt illo
            provident nobis accusamus eaque reiciendis vitae quam minus, quidem
            tempore praesentium esse.
          </p>
          <button class="btn rounded-pill btn-outline-danger">Book</button>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
