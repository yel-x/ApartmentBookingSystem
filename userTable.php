<?php
require 'components/layout.php';
require 'components/retrieveUserInfo.php';
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
                        <button type="button" class="btn btn-secondary rounded-pill btn-sm m-2" data-bs-toggle="modal"
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
                        <!-- Your existing form code -->
                        <form action="admin-dashboard.php" method="post">
                            <input type="hidden" name="userinfocopyEmail" value="<?php echo $user['email']; ?>">
                            <input type="hidden" name="operation" value="move">
                            <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#moveConfirmationModal<?php echo $user['id']; ?>">Rented</button>
                        </form>

                        <!-- Move Confirmation Modal -->
                        <div class="modal fade" id="moveConfirmationModal<?php echo $user['id']; ?>" tabindex="-1"
                            aria-labelledby="moveConfirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="moveConfirmationModalLabel">Additional Information</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="moveConfirmationForm<?php echo $user['id']; ?>" action="admin-dashboard.php"
                                            method="post">
                                            <input type="hidden" name="userinfocopyEmail" value="<?php echo $user['email']; ?>">
                                            <input type="hidden" name="operation" value="move">
                                            <div class="form-group mb-3">
                                                <label for="advancePay">Advance Payment?</label>
                                                <input type="number" class="form-control" name="advancePay" id="advancePay"
                                                    placeholder="Enter advance payment">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="rentAndExtra">Rent and additional:</label>
                                                <input type="text" class="form-control" name="rentAndExtra" id="rentAndExtra"
                                                    placeholder="Enter rent and additional info">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="dateToMove">When will they be moved?</label>
                                                <input type="date" class="form-control" name="dateToMove" id="dateToMove"
                                                    placeholder="Enter date to move">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger"
                                                    name="moveFromUserTable">Move</button>
                                            </div>
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