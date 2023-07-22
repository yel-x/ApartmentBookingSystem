<?php
require '../components/retrieveOngoing.php';
?>

<!-- ongoing table -->
<?php
$itemsPerPage = 10;
// Calculate total number of items and pages
$totalItems = count($ongoingUser);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = 1;
// Make sure $currentPage is within a valid range
if ($currentPage < 1) {

} elseif ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

// Calculate the offset to fetch the relevant data from the $ongoingUser array
$offset = ($currentPage - 1) * $itemsPerPage;
$paginatedData = array_slice($ongoingUser, $offset, $itemsPerPage);
?>

<!-- Display the table and pagination links -->
<?php if (empty($paginatedData)): ?>
    <p>No data available.</p>
<?php else: ?>
    <table class="table table-striped table-hover table-bordered shadow rounded-5">
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
            <?php
            $counter = $offset + 1; // Start counter from the correct value for the current page
            foreach ($paginatedData as $user):
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
                        <?php echo $user['title']; ?>
                    </td>
                    <td>
                        <?php echo $user['date']; ?>
                    </td>
                    <td>
                        <form action="admin-dashboard.php" method="post">
                            <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn btn-success rounded-pill btn-sm m-2"
                                name="moveToCompleteFromOngoing">Complete</button>
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
<?php endif; ?>