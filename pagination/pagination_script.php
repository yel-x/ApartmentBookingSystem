<?php
require '../components/retrieveAppointment.php';
?>

<!-- New user table -->
<?php
if (empty($appointment)) {
    echo '<p>No data available.</p>';
} else {
    // Pagination settings
    $rowsPerPage = 10;
    $totalRows = count($appointment);
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Get the current page from the URL query parameter 'page'
    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $currentPage = max(1, min($currentPage, $totalPages)); // Make sure the current page is within valid range

    // Calculate the starting index and ending index of data to display on the current page
    $startIndex = ($currentPage - 1) * $rowsPerPage;
    $endIndex = min($startIndex + $rowsPerPage, $totalRows);

    // Get the data for the current page
    $currentPageData = array_slice($appointment, $startIndex, $endIndex - $startIndex);

    // Counter for displaying row numbers
    $counter = ($currentPage - 1) * $rowsPerPage + 1;
    ?>

    <table class="table table-striped table-hover table-bordered shadow rounded-5" id="userTable">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Room Name</th>
                <th>Schedule</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($currentPageData as $user): ?>
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
                        <?php echo $user['title']; ?>
                    </td>
                    <td>
                        <?php echo $user['date']; ?>
                    </td>
                    <td>
                        <form action="admin-dashboard.php" method="post">
                            <input type="hidden" name="userId" value="<?php echo $user['aID']; ?>">
                            <button type="submit" class="btn btn-danger rounded-pill btn-sm p-2 mb-2 mb-lg-0"
                                name="moveToOngoing">Ongoing</button>
                            <button type="submit" class="btn btn-success rounded-pill btn-sm p-2 mb-lg-0"
                                name="moveToCompleteFromUserInfo">Complete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination links -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($currentPage > 1): ?>
                <li class="page-item">
                    <a class="page-link text-reset" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                    <a class="page-link text-reset" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link text-reset" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php } ?>