<?php
require 'retrieve.php';

// Check if userId exists in the URL
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    // Remove the login button and replace it with a logout button
    $logoutButton = '<a href="login.php" class="text-decoration-none text-white">Log out</a>';
} else {
    // Set userId to an empty value
    $userId = '';
    // Display the login button
    $logoutButton = '<a href="login.php" class="text-decoration-none text-white">Log in</a>';

    // Redirect the user to login.php if they clicked the account item
    if (isset($_GET['account']) && $userId === '') {
        header("Location: login.php");
        exit;
    }
}
require 'layout.php';
?>
<style>
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

    .addson::-webkit-scrollbar-thumb {
        border: 1px solid #9d8189;
        background-image: linear-gradient(45deg, #ffcad4, #f4acb7, #ffe5d9);
        border-radius: 10px;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>
</head>

<body>
    <!-- navlist and title -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offCanvas"
                aria-controls="offCanvas">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-list"
                    viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                </svg>
            </a>
            <span class="fw-bold flex-grow-1 text-end d-none d-md-block">Rizal Park's Apartment Booking System</span>
            <span class="fw-bold flex-grow-1 text-end d-block d-md-none">RPABS</span>
        </div>
        <!-- start of offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offCanvas" aria-labelledby="offCanvasLabel"
            data-bs-theme="dark">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offCanvaLabel">
                    <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>"
                        class="text-decoration-none text-white">RPABS</a>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled ms-4">
                    <li class="mt-3">
                        <a href="<?php echo $userId == 1 ? 'admin-dashboard.php?userId=' . $userId : 'account.php?userId=' . $userId; ?>"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                            Account
                        </a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#rooms"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-door-open-fill" viewBox="0 0 16 16">
                                <path
                                    d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z" />
                            </svg>
                            Rooms
                        </a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#addson"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>
                            Adds-on
                        </a>
                    </li>
                    <li class="mt-4">
                        <a href="index.php<?php echo $userId ? '?userId=' . $userId : ''; ?>#reviews"
                            class="text-decoration-none text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                class="bi bi-star-fill" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            Reviews
                        </a>
                    </li>
                </ul>
                <div class="mt-5 d-flex justify-content-center">
                    <button class="btn btn-lg logIn">
                        <?php echo $logoutButton; ?>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <script>
        const offcanvasElement = document.querySelector('#offCanvas');
        const offcanvasItems = offcanvasElement.querySelectorAll('li');

        offcanvasItems.forEach(item => {
            item.addEventListener('click', () => {
                const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                offcanvas.hide();
            });
        });

    </script>