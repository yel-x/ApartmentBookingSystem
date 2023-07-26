<?php
require 'components/layout.php';
require 'components/retrieveCopy.php';
?>

<h1>User Table</h1>
<?php if (empty($userinfocopy)): ?>
    <p>No data available in this table.</p>
<?php else: ?>
    <table class="table table-striped table-hover table-bordered shadow rounded-5" id="bookAppointment">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($userinfocopy as $user):
                ?>
                <tr>
                    <td>
                        <?php echo $counter++; ?>
                    </td>
                    <td>
                        <?php echo $user['fName']; ?>
                    </td>
                    <td>
                        <?php echo $user['lName']; ?>
                    </td>
                    <td>
                        <?php echo $user['email']; ?>
                    </td>
                    <td>
                        <?php echo $user['password']; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-success rounded-pill btn-sm m-2" data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal<?php echo $user['id']; ?>">
                            Delete
                        </button>
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
                            aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm
                                            Deletion
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this row?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="admin-dashboard.php" method="post">
                                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-danger"
                                                name="deleteFromUserTable">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>