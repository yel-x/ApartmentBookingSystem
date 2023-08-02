<?php
require 'components/layout.php';
require 'components/retrieveRenters.php';
?>

<h2>Renters</h2>

<?php if (empty($rented)): ?>
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
            foreach ($rented as $user):
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
                        <button class="btn btn-secondary rounded-pill btn-sm">Remove</button>
                        <form action="resetDueDate.php" method="post">
                            <input type="hidden" name="title" value="<?php echo $user['title']; ?>">
                            <button type="submit" class="btn btn-danger rounded-pill mt-2">Payed</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>