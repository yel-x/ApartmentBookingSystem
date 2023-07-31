<?php
require 'components/retrieveRooms.php';
// Check if a session is not already active before starting a new one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['rID'])) {
    $roomId = $_GET['rID'];
    // Perform the database deletion operation using mysqli
    $sql = "DELETE FROM rooms WHERE rID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId); // Assuming 'rID' is an integer field
    $stmt->execute();
    $stmt->close();
    $_SESSION['successMessage'] = "Succesfully deleted room";
    // Redirect back to the table page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

<div class="container">
    <h2>Rooms</h2>
    <a class="btn rounded-pill btn-danger" href="addNewRooms.php?userId=<?php echo $userId; ?>">Add new
        Rooms</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Picture</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td>
                        <?php echo $room['title']; ?>
                    </td>
                    <td>
                        <?php
                        $picture = $room['picture'];
                        // Split the picture string into an array of image URLs
                        $pictureUrls = ($picture !== '') ? explode("\n", $picture) : [];

                        // Get the first image URL
                        $firstImage = trim($pictureUrls[0]);
                        ?>

                        <!-- Now, display the first image if it exists -->
                        <?php if (!empty($firstImage) && file_exists($firstImage)): ?>
                            <img src="<?php echo $firstImage; ?>" alt="<?php echo $room['title']; ?>"
                                style="max-height: 100px;">
                        <?php else: ?>
                            <p>Image not found</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $room['description']; ?>
                    </td>
                    <td>
                        <?php echo $room['status']; ?>
                    </td>
                    <td>
                        <a class="btn rounded-pill btn-secondary"
                            href="UpdateRoom.php?userId=<?php echo $userId; ?>&rID=<?php echo $room['rID']; ?>">Update</a>
                        <a class="btn rounded-pill btn-danger"
                            href="Rooms.php?userId=<?php echo $userId; ?>&rID=<?php echo $room['rID']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>