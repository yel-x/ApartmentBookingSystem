<?php
require 'retrieve.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
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
</head>

<body>
    <!-- navlist and title -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-between">
            <a class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </a>
            <span class="fw-bold flex justify-content-end">Rizal Park's Apartment Booking System</span>
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel" data-bs-theme="dark">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                    <a href="index.php?id=<?php echo $userId; ?>" class="text-decoration-none text-white">RPABS</a>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled ms-4">
                    <li class="mt-3">
                        <a href="account.php?id=<?php echo $userId; ?>
            " class="text-decoration-none text-white"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            Account</a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php?id=<?php echo $userId; ?>#rooms" class="text-decoration-none text-white"><svg
                                xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-door-open-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                            </svg>Rooms</a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php?id=<?php echo $userId; ?>#addson"
                            class="text-decoration-none text-white"><svg xmlns="http://www.w3.org/2000/svg" width="30"
                                height="30" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>Adds-on</a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php?id=<?php echo $userId; ?>#reviews"
                            class="text-decoration-none text-white"><svg xmlns="http://www.w3.org/2000/svg" width="30"
                                height="30" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>Reviews</a>
                    </li>
                </ul>
                <div class="mt-5 d-flex justify-content-center">
                    <button class="btn btn-lg logIn">
                        <a href="login.php" class="text-decoration-none text-white">Log in</a>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>