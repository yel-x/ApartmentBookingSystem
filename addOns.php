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
                        <Button class="btn rounded-pill btn-secondary">Update</Button>
                        <Button class="btn rounded-pill btn-danger">Delete</Button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>