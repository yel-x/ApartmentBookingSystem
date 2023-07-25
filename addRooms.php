<?php
require 'components/layout.php';
require 'components/retrieveRooms.php';
?>

<div class="container">
    <h2>Rooms</h2>
    <button class="btn rounded-pill btn-danger">Add new Rooms</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Picture</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room):
                // Use regular expression to match all image URLs in the 'picture' field
                preg_match_all('/(?:uploads[\\\\\\/ ]+[\w.-]+)/', $room['picture'], $images);
                $images = $images[0];
                ?>
                <tr>
                    <td>
                        <?php echo $room['title']; ?>
                    </td>
                    <td>
                        <?php
                        if (count($images) > 0) {
                            // Get the first image URL
                            $firstImage = trim($images[0]);
                        } else {
                            // No images found
                            $firstImage = ''; // Set to empty string if no images found
                        }

                        // Check if the file exists before displaying the image
                        if (!empty($firstImage) && file_exists($firstImage)) {
                            echo '<img src="' . $firstImage . '" alt="' . $room['title'] . '" style="max-height: 100px;">';
                        } else {
                            echo 'Image not found';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $room['description']; ?>
                    </td>
                    <td><Button class="btn rounded-pill btn-secondary">Update</Button>
                        <Button class="btn rounded-pill btn-danger">Delete</Button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>