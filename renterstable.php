<?php
require 'components/layout.php';
require 'components/retrieveRenters.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if (isset($_POST['useAdvancePayment'])) {
    // Get the title from the submitted form data
    $title = $_POST['useAdvancePayment'];

    // Ensure the title is not empty
    if (!empty($title)) {
        // Get the email associated with the rented room
        $getEmailQuery = "SELECT email FROM rented WHERE title = '$title'";
        $result = mysqli_query($conn, $getEmailQuery);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];

        // Get the current advancePayment and room price
        $getPaymentQuery = "SELECT advancePayment FROM rented WHERE title = '$title'";
        $result = mysqli_query($conn, $getPaymentQuery);
        $row = mysqli_fetch_assoc($result);
        $advancePayment = (float) $row['advancePayment'];

        // Get the room price from the rooms table
        $getPriceQuery = "SELECT price FROM rooms WHERE title = '$title'";
        $result = mysqli_query($conn, $getPriceQuery);
        $row = mysqli_fetch_assoc($result);
        $price = (float) $row['price'];

        // Calculate the remaining advancePayment after deducting the room price
        $remainingAdvancePayment = $advancePayment - $price;

        // Update the advancePayment in the rented table using the email
        $updateQuery = "UPDATE rented SET advancePayment = '$remainingAdvancePayment' WHERE email = '$email'";
        $updateResult = mysqli_query($conn, $updateQuery);
        if ($updateResult) {
            $_SESSION['successMessage'] = 'Advance payment successfully used.';
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
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
                <th>Due Date</th>
                <th>Advance Payment Balance</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($rented as $user):
                // Calculate the due date for the current rented user
                $dateMoved = strtotime($user['dateMoved']);
                $dueDate = date('M d, Y', strtotime('+1 month', $dateMoved));
                // Calculate the number of days remaining until the due date
                $currentDate = time(); // Current timestamp
                $dueDateTimestamp = strtotime($dueDate);
                $daysRemaining = floor(($dueDateTimestamp - $currentDate) / (60 * 60 * 24));
                // Check if the user has advancePayment greater than 0
                $advancePayment = (float) $user['advancePayment'];
                $hasPositiveAdvancePayment = $advancePayment > 0;
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
                        <?php echo $dueDate; ?>
                    </td>
                    <td>
                        <?php echo $advancePayment; ?>
                    </td>
                    <td>
                        <form action="removeRented.php" method="post">
                            <input type="hidden" name="email" value="<?php echo $user['email']; ?>">
                            <button type="submit" class="btn btn-secondary rounded-pill btn-sm">Remove</button>
                        </form>
                        <form action="resetDueDate.php" method="post">
                            <input type="hidden" name="title" value="<?php echo $user['title']; ?>">
                            <button type="submit" class="btn btn-danger rounded-pill mt-2">Payed</button>
                        </form>
                        <?php if ($hasPositiveAdvancePayment): ?>
                            <form action="renterstable.php" method="post">
                                <input type="hidden" name="useAdvancePayment" value="<?php echo $user['title']; ?>">
                                <button type="submit" class="btn btn-outline-danger rounded-pill mt-2">Use Advance Payment</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>