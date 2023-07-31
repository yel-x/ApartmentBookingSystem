<?php
require 'components/retrieveAddsOn.php';

// Check if a session is not already active before starting a new one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['id'])) {
    $addsonsId = $_GET['id'];
    // Perform the database deletion operation using mysqli
    $sql = "DELETE FROM addson WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $addsonsId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['successMessage'] = "Succesfully deleted an ammenity";
    // Redirect back to the table page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
<div class="container">
    <h2>Ammeneties</h2>
    <a href="addNewAmme.php?userId=<?php echo $userId; ?>" class="btn rounded-pill btn-danger">Add Ammeneties</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Picture</th>
                <th>Description</th>
                <th>Availability</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($addsons as $addsons): ?>
                <tr>
                    <td>
                        <?php echo $addsons['title']; ?>
                    </td>
                    <td>
                        <?php
                        $picture = $addsons['picture'];
                        // Split the picture string into an array of image URLs
                        $pictureUrls = ($picture !== '') ? explode("\n", $picture) : [];

                        // Get the first image URL
                        $firstImage = trim($pictureUrls[0]);
                        ?>

                        <!-- Now, display the first image if it exists -->
                        <?php if (!empty($firstImage) && file_exists($firstImage)): ?>
                            <img src="<?php echo $firstImage; ?>" alt="<?php echo $addsons['title']; ?>"
                                style="max-height: 100px;">
                        <?php else: ?>
                            <p>Image not found</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $addsons['description']; ?>
                    </td>
                    <td>
                        <?php echo $addsons['availability']; ?>
                    </td>
                    <td>
                        <?php echo $addsons['price']; ?>
                    </td>
                    <td>
                        <a class="btn rounded-pill btn-secondary"
                            href="updateAmme.php?userId=<?php echo $userId; ?>&id=<?php echo $addsons['id']; ?>">Update</a>
                        <a class="btn rounded-pill btn-danger"
                            href="addOns.php?userId=<?php echo $userId; ?>&id=<?php echo $addsons['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>