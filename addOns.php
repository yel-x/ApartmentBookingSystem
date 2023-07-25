<?php
require 'components/layout.php';
require 'components/retrieveAddsOn.php';
?>

<div class="container">
    <h2>Ammeneties</h2>
    <button class="btn rounded-pill btn-danger">Add Ammeneties</button>
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
            <?php foreach ($addsons as $addson):
                // Use regular expression to match all image URLs in the 'picture' field
                preg_match_all('/(?:uploads[\\\\\\/ ]+[\w.-]+)/', $addson['picture'], $images);
                $images = $images[0];
                ?>
                <tr>
                    <td>
                        <?php echo $addson['title']; ?>
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
                            echo '<img src="' . $firstImage . '" alt="' . $addson['title'] . '" style="max-height: 100px;">';
                        } else {
                            echo 'Image not found';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $addson['description']; ?>
                    </td>
                    <td><Button class="btn rounded-pill btn-secondary">Update</Button>
                        <Button class="btn rounded-pill btn-danger">Delete</Button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>