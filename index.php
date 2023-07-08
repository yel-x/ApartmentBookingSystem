<?php
require 'components/retrieve.php';
require 'components/layout.php';
?>
<title>RPABS</title>
</head>

<body class="bg-body-secondary">
  <div class="container">
  </div>
  <?php require 'components/navbar.php'; ?>
  <!-- carousel features -->
  <div id="carouselExampleIndicators"
    class="carousel slide carousel-fade carousel-dark bg-danger-subtle mt-3 mt-md-5 mx-4 mx-md-5">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active rounded-5"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="rounded-5"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="rounded-5"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner d-flex justify-content-between ms-4 ps-3 pb-5 pt-3 pt-lg-3 ms-lg-5 ps-lg-5">
      <div class="carousel-item active ms-3 me-5">
        <div class="d-flex align-items-center">
          <img src="assets/pexels-thorsten-technoman-338504.jpg" class="portrait-img" alt="features" />
          <div class="pe-5 ps-3">
            <h4>Lorem ipsum</h4>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Voluptatum pariatur facilis consequuntur temporibus
            </p>
          </div>
        </div>
      </div>
      <div class="carousel-item ms-3 me-5">
        <div class="d-flex align-items-center">
          <img src="assets/pexels-thorsten-technoman-338504.jpg" class="portrait-img" alt="features" />
          <div class="pe-5 ps-3">
            <h4>Lorem ipsum</h4>
            <p class="">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Voluptatum pariatur facilis consequuntur temporibus
            </p>
          </div>
        </div>
      </div>
      <div class="carousel-item ms-3 me-5">
        <div class="d-flex align-items-center">
          <img src="assets/pexels-thorsten-technoman-338504.jpg" class="portrait-img" alt="features" />
          <div class="pe-5 ps-3">
            <h4>Lorem ipsum</h4>
            <p class="">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Voluptatum pariatur facilis consequuntur temporibus
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- button indicators -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <hr />
  <!-- rooms -->
  <section id="rooms">
    <div class="container-sm pt-3">
      <!-- room 1 -->
      <div class="mb-3">
        <div class="d-lg-flex">
          <div class="pt-3 p-lg-3">
            <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="" class="card-img" style="width: 18rem" />
          </div>
          <div class="pt-2 p-lg-3 mt-3 mt-lg-5">
            <h2>Room 1</h2>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit.
              Doloribus nihil provident modi totam nesciunt dolorum accusamus
              placeat at ullam ut?
            </p>
          </div>
        </div>
      </div>
      <!-- room 2 -->
      <div class="mb-3">
        <div class="d-lg-flex flex-row-reverse">
          <div class="pt-5">
            <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="" class="card-img" style="width: 18rem" />
          </div>
          <div class="pt-2 p-lg-5 mt-3 mt-lg-5">
            <h2 class="text-lg-end">Room 2</h2>
            <p class="text-lg-end">
              Lorem ipsum dolor sit, amet consectetur adipisicing elit.
              Doloribus nihil provident modi totam nesciunt dolorum accusamus
              placeat at ullam ut?
            </p>
          </div>
        </div>
      </div>
      <!-- room 3 -->
      <div class="mb-3">
        <div class="d-lg-flex">
          <div class="pt-3 p-lg-3">
            <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="" class="card-img" style="width: 18rem" />
          </div>
          <div class="pt-2 p-lg-3 mt-3 mt-lg-5">
            <h2>Room 3</h2>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit.
              Doloribus nihil provident modi totam nesciunt dolorum accusamus
              placeat at ullam ut?
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- adds on -->
  <section id="addson">
    <div class="container-fluid bg-danger-subtle">
      <h1 class="text-center">Adds on</h1>
      <p class="text-center">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nulla
        expedita quos dolorem. Nostrum vitae fugiat, culpa quis molestiae
        provident!
      </p>
      <div class="addson d-flex justify-content-between overflow-x-scroll m-3 m-lg-5">
        <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            " class="me-5" />
        <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            " />
        <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            " class="mx-5" />
        <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            " />
        <img src="assets/pexels-thorsten-technoman-338504.jpg" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            " class="ms-5" />
      </div>
    </div>
  </section>
  <!-- review -->
  <section id="reviews">
    <div class="container-fluid mb-5">
      <h1 class="text-center">Reviews</h1>
      <p class="text-center">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi ea
        pariatur velit expedita ullam provident doloremque voluptate assumenda
        accusamus perspiciatis?
      </p>
      <div class="card mx-lg-5 mx-3 mt-3" style="width: auto">
        <div class="card-body">
          <div class="d-flex">
            <h5 class="card-title pe-3">Jose Rizal</h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
          </div>

          <p class="card-text">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio impedit, est consectetur doloremque praesentium
            voluptatum veritatis a. Veniam, recusandae est.
          </p>
        </div>
      </div>
      <div class="card mx-lg-5 mx-3 mt-3" style="width: auto">
        <div class="card-body">
          <div class="d-flex">
            <h5 class="card-title pe-3">Jose Rizal</h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
          </div>

          <p class="card-text">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio impedit, est consectetur doloremque praesentium
            voluptatum veritatis a. Veniam, recusandae est.
          </p>
        </div>
      </div>
      <div class="card mx-lg-5 mx-3 mt-3" style="width: auto">
        <div class="card-body">
          <div class="d-flex">
            <h5 class="card-title pe-3">Jose Rizal</h5>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
              class="bi bi-star-fill mt-1 me-1" viewBox="0 0 16 16">
              <path
                d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
            </svg>
          </div>

          <p class="card-text">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit.
            Distinctio impedit, est consectetur doloremque praesentium
            voluptatum veritatis a. Veniam, recusandae est.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- footer -->
  <footer>
    <div class="bg-danger pb-1 sticky-bottom">
      <p class="text-center text-white align-bottom">
        Read all Terms and Conditions. All rights reseve 2023 ©
      </p>
    </div>
  </footer>

  <script>
    // JavaScript code to handle smooth scrolling when clicking navigation links
    document.addEventListener('DOMContentLoaded', function () {
      var navLinks = document.querySelectorAll('#offcanvas a');

      navLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          var targetId = this.getAttribute('href').substring(1);
          var targetSection = document.getElementById(targetId);

          if (targetSection) {
            // Use smooth scrolling behavior
            targetSection.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    });
  </script>