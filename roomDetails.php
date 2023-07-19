<?php
require 'components/retrieveRooms.php';
require 'components/navbar.php';

// Check if the rID query parameter is set
if (isset($_GET['rID'])) {
    // Get the room ID from the query parameter and ensure it's an integer (for security)
    $roomID = intval($_GET['rID']);

    // Find the room with the matching room ID
    $selectedRoom = null;
    foreach ($rooms as $room) {
        if ($room['rID'] == $roomID) {
            $selectedRoom = $room;
            break;
        }
    }
    // If the room with the specified ID was found, set variables for title, description, and picture
    if ($selectedRoom) {
        $title = $selectedRoom['title'];
        $description = $selectedRoom['description'];
        $picture = $selectedRoom['picture'];

        // Split the $picture string into an array of URLs using line breaks as delimiters
        $pictureUrls = ($picture !== '') ? explode("\n", $picture) : [];
    } else {
        // Handle the case when the room with the specified ID was not found (optional)
        $title = 'Room Not Found';
        $description = 'This room does not exist or has been removed.';
        $picture = 'path/to/default-image.jpg';
        $pictureUrls = [];
    }
} else {
    // Handle the case when the rID query parameter is not set (optional)
    $title = 'Room Not Specified';
    $description = 'Please select a valid room.';
    $picture = 'path/to/default-image.jpg';
    $pictureUrls = [];
}

$pictureUrls = ($picture !== '') ? array_filter(explode("\n", $picture), 'trim') : [];
?>

<style>
    img {
        width: 100%;
        height: 30em;
        object-fit: cover;
        margin: 0 auto;
    }
</style>

<title>Room Details</title>
</head>
<div class="container mt-0 mt-lg-5">
    <div class="row mb-3 mb-lg-5">
        <!-- room pics -->
        <div class="col-lg-6 mb-3">
            <!-- Carousel -->
            <?php if (!empty($pictureUrls)): ?>
                <?php if (count($pictureUrls) > 1): ?>
                    <div id="carouselIndicators" class="carousel slide carousel-dark bg-danger-subtle rounded rounded-3 shadow"
                        data-bs-ride="carousel">
                        <!-- Show the carousel indicators if there are more than one picture -->
                        <div id="carouselIndicatorsOutside" class="carousel-indicators d-block d-flex justify-content-center">
                            <?php for ($i = 0; $i < count($pictureUrls); $i++): ?>
                                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?php echo $i; ?>"
                                    <?php echo ($i === 0) ? 'class="active" aria-current="true"' : ''; ?>
                                    aria-label="Slide <?php echo $i + 1; ?>"></button>
                            <?php endfor; ?>
                        </div>

                        <div class="carousel-inner">
                            <?php for ($i = 0; $i < count($pictureUrls); $i++): ?>
                                <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                                    <?php if (isset($pictureUrls[$i])): ?>
                                        <img src="<?php echo trim($pictureUrls[$i]); ?>"
                                            class="d-block object-fit-cover rounded rounded-3" alt="...">
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Show the single picture without indicators -->
                    <div class="col-lg-10 mb-3">
                        <img src="<?php echo trim($pictureUrls[0]); ?>" class="d-block object-fit-cover rounded rounded-3"
                            alt="...">
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <!-- room details -->
        <div class="col-lg-6">
            <div class="container text-center border border-5">
                <div class="row">
                    <div class="col">
                        <h2>
                            <?php echo $title; ?>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p>
                            <?php echo $description; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- appoint button -->
    <div class="row mb-5">
        <div class="d-flex justify-content-center">
            <?php if (isset($_GET['userId'])): ?>
                <!-- Redirect to bookForm.php for logged-in users -->
                <a href="bookForm.php?userId=<?php echo urlencode($_GET['userId']); ?>&rID=<?php echo $room['rID']; ?>"
                    class="btn btn-outline-danger rounded-pill w-50 text-decoration-none">Appoint</a>
            <?php else: ?>
                <!-- Redirect to login.php for users not logged in -->
                <a href="login.php" class="btn btn-outline-danger rounded-pill w-50 text-decoration-none">Appoint</a>
            <?php endif; ?>
        </div>

    </div>
</div>