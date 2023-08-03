<?php
ob_start();
session_start();
require 'components/navbar.php';
require 'components/retrieveReviews.php';
require 'components/retrieve.php';

$reviewContent = '';
$star = '';
$errors = [];
$errorMessage = '';
// Check if userId exists in the URL
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $reviewContent = $_POST['reviewContent'];
    $star = isset($_POST['star']) ? $_POST['star'] : '';

    // Perform server-side validation
    if (empty($fName)) {
        $errors['fName'] = 'First name is required.';
    }

    if (empty($lName)) {
        $errors['lName'] = 'Last name is required.';
    }

    if (empty($reviewContent)) {
        $errors['reviewContent'] = 'Review content is required.';
    }

    if (empty($star)) {
        $errors['star'] = 'Star rating is required.';
    }

    // If there are no errors, store the data in the "reviews" table
    if (empty($errors)) {
        // Query to check for matching records
        $checkQuery = "SELECT COUNT(*) AS count FROM reviews WHERE fName = ? AND lName = ?";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param('ss', $fName, $lName);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $row = $result->fetch_assoc();
        $matchingReviewsCount = $row['count'];

        $checkStmt->close();

        // If matching records found, don't submit and show an error message
        if ($matchingReviewsCount > 0) {
            $errorMessage = 'You have alreay left a review. Thank you!';
        } else {
            // Insert the review into the "reviews" table
            $insertQuery = "INSERT INTO reviews (fName, lName, star, content) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param('ssis', $fName, $lName, $star, $reviewContent);

            if ($insertStmt->execute()) {
                $_SESSION['successMessage'] = 'Review submitted successfully.';
                // Redirect back to account.php with only the userId in the URL
                $redirectUrl = 'account.php?userId=' . urlencode($userId);
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $errorMessage = 'Error submitting review: ' . $conn->error;
            }
            $insertStmt->close();
        }

        $conn->close();
    }
}
ob_end_flush();
?>

<title>Review</title>

<div class="container">
    <h2>Kindly leave us a review</h2>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <form class="row g-3 needs-validation" method="post" novalidate>
        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">First name</label>
            <input type="text" class="form-control <?php echo isset($errors['fName']) ? 'is-invalid' : ''; ?>"
                id="validationCustom01" name="fName" value="<?php echo htmlspecialchars($fName); ?>" required>
            <?php if (isset($errors['fName'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['fName']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">Last name</label>
            <input type="text" class="form-control <?php echo isset($errors['lName']) ? 'is-invalid' : ''; ?>"
                id="validationCustom02" name="lName" value="<?php echo htmlspecialchars($lName); ?>" required>
            <?php if (isset($errors['lName'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['lName']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <label for="validationCustom03" class="form-label">Review Content:</label>
            <input type="text" class="form-control <?php echo isset($errors['reviewContent']) ? 'is-invalid' : ''; ?>"
                id="validationCustom03" name="reviewContent" value="<?php echo htmlspecialchars($reviewContent); ?>"
                required>
            <?php if (isset($errors['reviewContent'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['reviewContent']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-3">
            <label for="validationCustom04" class="form-label">Star</label>
            <select class="form-select <?php echo isset($errors['star']) ? 'is-invalid' : ''; ?>"
                id="validationCustom04" name="star" required>
                <option selected disabled value="">Open this</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <?php if (isset($errors['star'])): ?>
                <div class="invalid-feedback">
                    <?php echo $errors['star']; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
            <a class="btn btn-primary" href="account.php?userId=<?php echo urlencode($userId); ?>">Go back</a>
        </div>
    </form>
</div>