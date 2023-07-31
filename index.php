<?php
require 'components/retrieve.php';
require 'components/retrieveRooms.php';
require 'components/retrieveAddsOn.php';
require 'components/layout.php';

// Assuming $roomNumber contains the room number for each iteration
$roomNumber = 1; // Replace this with the actual room number

// Add a conditional class based on even/odd room number
$evenClass = $roomNumber % 2 === 0 ? 'flex-row-reverse' : '';
?>
<style>
  .carouselBtn {
    margin: 0 150px;
  }

  .carousel-inner img {
    width: 100%;
    height: 30em;
    object-fit: cover;
    margin: 0 auto;
  }
</style>
<title>RPABS</title>
</head>

<body class="bg-body-secondary">
  <?php require 'components/navbar.php'; ?>
  <!-- carousel features -->
  <div class="container pt-3">
    <div class="row">
      <div class="col col-12 col-lg-2"></div>
      <!-- start of the carousel -->
      <div class="col col-12 col-lg-8">
        <div id="carousel" class="carousel slide carousel-dark bg-danger-subtle rounded rounded-3 shadow"
          data-bs-ride="carousel">
          <!-- carousel indicators -->
          <div class="d-block d-xl-none">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
          </div>
          <div class="carousel-inner ">
            <div class="carousel-item active">
              <img src="assets/pexels-thorsten-technoman-338504.jpg" class=" d-block  rounded rounded-3 w-100"
                alt="...">
              <div class="carousel-caption d-none d-md-block position-absolute top-0 end-0 text-end pe-3">
                <h5>First slide label</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque iusto accusantium dolorem dignissimos
                  quo quisquam qui ullam possimus nulla porro?.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="uploads\Yae-Miko-birthday-art-2022-genshinimpact.jpg" class=" d-block  rounded rounded-3 w-100"
                alt="...">
              <div class="carousel-caption d-none d-md-block position-absolute top-0 end-0 text-end pe-3">
                <h5>Second slide label</h5>
                <p>Some representative placeholder content for the second slide.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="uploads\F0kQliLXsAEi8ic.jpg" class=" d-block  rounded rounded-3 w-100" alt="...">
              <div class="carousel-caption d-none d-md-block  position-absolute top-0 end-0 text-end pe-3">
                <h5>Third slide label</h5>
                <p>Some representative placeholder content for the third slide.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- buttons for carousel -->
        <button class="carouselBtn carousel-control-prev d-none d-xl-block" type="button" data-bs-target="#carousel"
          data-bs-slide="prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-caret-left"
            viewBox="0 0 16 16">
            <path
              d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z" />
          </svg>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carouselBtn carousel-control-next  d-none d-xl-block" type="button" data-bs-target="#carousel"
          data-bs-slide="next">
          <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-caret-right"
            viewBox="0 0 16 16">
            <path
              d="M6 12.796V3.204L11.481 8 6 12.796zm.659.753 5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z" />
          </svg>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div class="col col-4 col-lg-2"></div>
    </div>
  </div>
  <hr />
  <!-- rooms -->
  <section id="rooms">
    <div class="container-sm py-3">
      <!-- room 1 -->
      <?php foreach ($rooms as $room): ?>
        <div class="mb-3 mx-lg-5 px-lg-5">
          <div class="d-lg-flex <?php echo $room['rID'] % 2 === 0 ? 'flex-row-reverse' : ''; ?>">
            <div class="pt-3 p-lg-3">
              <?php if (isset($room['picture']) && !empty(trim($room['picture']))): ?>
                <?php
                // Split the picture URLs into an array using line breaks as delimiters
                $pictureUrls = explode("\n", $room['picture']);
                // Take the first URL from the array
                $firstPictureUrl = isset($pictureUrls[0]) ? trim($pictureUrls[0]) : null;
                ?>
                <!-- Wrap the room content inside an anchor tag with a link to roomDetails page -->
                <a class="text-decoration-none text-reset"
                  href="<?php echo $userId && !empty($userId) ? 'roomDetails.php?userId=' . $userId . '&rID=' . $room['rID'] : 'roomDetails.php?rID=' . $room['rID']; ?>">
                  <img src="<?php echo $firstPictureUrl; ?>" alt="" class="card-img rounded rounded-3"
                    style="width: 300px; height: 200px; object-fit: cover;" />
                </a>
              <?php endif; ?>
            </div>
            <div class="pt-2 mt-3 mt-lg-5">
              <?php if (isset($room['title'])): ?>
                <!-- Wrap the room title inside an anchor tag with a link to roomDetails page -->
                <a class="text-decoration-none text-reset"
                  href="<?php echo $userId && !empty($userId) ? 'roomDetails.php?userId=' . $userId . '&rID=' . $room['rID'] : 'roomDetails.php?rID=' . $room['rID']; ?>">
                  <h2 class="<?php echo $room['rID'] % 2 === 0 ? 'text-lg-end' : ''; ?>">
                    <?php echo $room['title']; ?>
                  </h2>
                </a>
              <?php endif; ?>
              <?php if (isset($room['description'])): ?>
                <p class="<?php echo $room['rID'] % 2 === 0 ? 'text-lg-end' : ''; ?>">
                  <?php echo $room['description']; ?>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
  <!-- adds on -->
  <section id="addson">
    <div class="container-fluid bg-danger-subtle pt-3">
      <h1 class="text-center">Adds on</h1>
      <p class="text-center">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non nulla expedita quos dolorem. Nostrum vitae fugiat,
        culpa quis molestiae provident!
      </p>
      <div class="addson d-flex justify-content-between overflow-x-scroll m-3 m-lg-5">
        <?php
        foreach ($addsons as $index => $addon) {
          $imageUrl = $addon['picture'];
          $title = $addon['title'];
          $description = $addon['description'];
          $availability = $addon['availability'];
          $price = $addon['price'];
          ?>
          <img src="<?php echo $imageUrl; ?>" alt="addson" style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
              cursor: pointer; /* Add this line to show the pointer cursor on the images */
            " class="me-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-title="<?php echo $title; ?>"
            data-description="<?php echo $description; ?>" data-availability="<?php echo $availability; ?>"
            data-price="<?php echo $price; ?>" />
        <?php } ?>
      </div>
    </div>
    <!-- Add the following code anywhere in your HTML, preferably after the addson section -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p id="modal-description"></p>
            <img src="" id="modal-image" style="width: 100%; max-height: 300px;" class="object-fit-contain"
              alt="addson" />
            <p>Availability: <span id="modal-availability"></span></p>
            <p>Price: <span id="modal-price"></span></p>
          </div>
        </div>
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
    // Add this script anywhere after the Bootstrap and jQuery scripts are loaded.

    document.addEventListener("DOMContentLoaded", function () {
      const modalTitleElement = document.getElementById("modal-title");
      const modalDescriptionElement = document.getElementById("modal-description");
      const modalImageElement = document.getElementById("modal-image");
      const modalAvailabilityElement = document.getElementById("modal-availability");
      const modalPriceElement = document.getElementById("modal-price");

      // Attach an event listener to each image with the class "me-4" (this class is set on the images in the loop)
      const images = document.querySelectorAll(".me-4");
      images.forEach((image) => {
        image.addEventListener("click", function () {
          // Get the data from the data attributes
          const title = this.getAttribute("data-title");
          const description = this.getAttribute("data-description");
          const imageUrl = this.getAttribute("src");
          const availability = this.getAttribute("data-availability");
          const price = this.getAttribute("data-price");

          // Populate the modal content with the fetched data
          modalTitleElement.textContent = title;
          modalDescriptionElement.textContent = description;
          modalImageElement.src = imageUrl;
          modalAvailabilityElement.textContent = availability;
          modalPriceElement.textContent = price;
        });
      });
    });
  </script>

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