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
    <style>
      .portrait-img {
        height: 20rem;
        width: 10rem;
        object-fit: cover;
      }
      .logIn {
        background: linear-gradient(315deg, #0049ff, #d25f72, #a71a31);
        background-size: 600% 600%;

        animation: logInButton 13s ease infinite;
      }

      @keyframes logInButton {
        0% {
          background-position: 0% 10%;
        }
        50% {
          background-position: 100% 91%;
        }
        100% {
          background-position: 0% 10%;
        }
      }
      .addson::-webkit-scrollbar {
        background-color: transparent;
      }
    </style>
    <title>RPABS</title>
  </head>
  <body class="bg-body-secondary">
    <!-- navlist and title -->
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid justify-content-between">
        <a
          class="btn"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#offcanvasExample"
          aria-controls="offcanvasExample"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="30"
            height="30"
            fill="currentColor"
            class="bi bi-list"
            viewBox="0 0 16 16"
          >
            <path
              fill-rule="evenodd"
              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
            />
          </svg>
        </a>
        <span class="fw-bold flex justify-content-end"
          >Rizal Park's Apartment Booking System</span
        >
      </div>
      <div
        class="offcanvas offcanvas-start"
        tabindex="-1"
        id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel"
        data-bs-theme="dark"
      >
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">
            <a href="index.html" class="text-decoration-none text-white"
              >RPABS</a
            >
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>
        <div class="offcanvas-body">
          <ul class="list-unstyled ms-4">
            <li class="mt-3">
              <a href="account.html" class="text-decoration-none text-white"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="30"
                  height="30"
                  fill="currentColor"
                  class="bi bi-person-circle"
                  viewBox="0 0 16 16"
                >
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                  <path
                    fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                  />
                </svg>
                Account</a
              >
            </li>
            <li class="mt-4">
              <a href="#rooms" class="text-decoration-none text-white"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="30"
                  height="30"
                  fill="currentColor"
                  class="bi bi-door-open-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"
                  /></svg
                >Rooms</a
              >
            </li>
            <li class="mt-4">
              <a href="#addson" class="text-decoration-none text-white"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="30"
                  height="30"
                  fill="currentColor"
                  class="bi bi-heart-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"
                  /></svg
                >Adds-on</a
              >
            </li>
            <li class="mt-4">
              <a href="#reviews" class="text-decoration-none text-white"
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="30"
                  height="30"
                  fill="currentColor"
                  class="bi bi-star-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                  /></svg
                >Reviews</a
              >
            </li>
          </ul>
          <div class="mt-5 d-flex justify-content-center">
            <button class="btn btn-lg logIn">
              <a href="login.html" class="text-decoration-none text-white"
                >Log in</a
              >
            </button>
          </div>
        </div>
      </div>
    </nav>
    <!-- carousel features -->
    <div
      id="carouselExampleIndicators"
      class="carousel slide carousel-fade carousel-dark bg-danger-subtle mt-3 mt-md-5 mx-4 mx-md-5"
    >
      <div class="carousel-indicators">
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="0"
          class="active rounded-5"
          aria-current="true"
          aria-label="Slide 1"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="1"
          class="rounded-5"
          aria-label="Slide 2"
        ></button>
        <button
          type="button"
          data-bs-target="#carouselExampleIndicators"
          data-bs-slide-to="2"
          class="rounded-5"
          aria-label="Slide 3"
        ></button>
      </div>
      <div
        class="carousel-inner d-flex justify-content-between ms-4 ps-3 pb-5 pt-3 pt-lg-3 ms-lg-5 ps-lg-5"
      >
        <div class="carousel-item active ms-3 me-5">
          <div class="d-flex align-items-center">
            <img
              src="assets/pexels-thorsten-technoman-338504.jpg"
              class="portrait-img"
              alt="features"
            />
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
            <img
              src="assets/pexels-thorsten-technoman-338504.jpg"
              class="portrait-img"
              alt="features"
            />
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
            <img
              src="assets/pexels-thorsten-technoman-338504.jpg"
              class="portrait-img"
              alt="features"
            />
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
    <hr />
    <!-- rooms -->
    <section id="rooms">
      <div class="container-sm pt-3">
        <!-- room 1 -->
        <div class="mb-3">
          <div class="d-lg-flex">
            <div class="pt-3 p-lg-3">
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                alt=""
                class="card-img"
                style="width: 18rem"
              />
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
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                alt=""
                class="card-img"
                style="width: 18rem"
              />
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
              <img
                src="assets/pexels-thorsten-technoman-338504.jpg"
                alt=""
                class="card-img"
                style="width: 18rem"
              />
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
        <div
          class="addson d-flex justify-content-between overflow-x-scroll m-3 m-lg-5"
        >
          <img
            src="assets/pexels-thorsten-technoman-338504.jpg"
            alt="addson"
            style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            "
            class="me-5"
          />
          <img
            src="assets/pexels-thorsten-technoman-338504.jpg"
            alt="addson"
            style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            "
          />
          <img
            src="assets/pexels-thorsten-technoman-338504.jpg"
            alt="addson"
            style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            "
            class="mx-5"
          />
          <img
            src="assets/pexels-thorsten-technoman-338504.jpg"
            alt="addson"
            style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            "
          />
          <img
            src="assets/pexels-thorsten-technoman-338504.jpg"
            alt="addson"
            style="
              width: 15rem;
              height: 25rem;
              object-fit: cover;
              border-radius: 15px;
            "
            class="ms-5"
          />
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
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
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
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
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
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
              </svg>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="currentColor"
                class="bi bi-star-fill mt-1 me-1"
                viewBox="0 0 16 16"
              >
                <path
                  d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"
                />
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
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
