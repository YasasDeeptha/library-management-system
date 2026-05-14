<?php 
if(session_status() === PHP_SESSION_NONE) session_start();

$page_title = 'Edit Fine';

include '../../config/database.php';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 

// Get Fine ID
$fine_id = mysqli_real_escape_string($conn, trim($_GET['id'] ?? ''));

if($fine_id === ''){
    $_SESSION['error'] = "No Fine ID provided.";
    header("Location: manage.php");
    exit;
}

// Fetch fine record
$sql = "SELECT f.*, 
               CONCAT(m.first_name, ' ', m.last_name) AS member_name,
               b.book_name
        FROM fine f
        JOIN member m ON f.member_id = m.member_id
        JOIN book b   ON f.book_id = b.book_id
        WHERE f.fine_id = '$fine_id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(!$row){
    $_SESSION['error'] = "Fine record not found.";
    header("Location: manage.php");
    exit;
}
?>

<main class="main-content">

    <?php include '../../includes/navbar.php'; ?>

    <div class="page-content">

        <div class="lms-card">

            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Update Fine</h5>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="b_edit.php" method="POST">

                <!-- Hidden Fine ID -->
                <input type="hidden" 
                       name="fine_id"
                       value="<?= htmlspecialchars($row['fine_id']) ?>">

                <!-- Fine ID -->
                <div class="mb-3">
                    <label class="form-label small fw-medium">
                        Fine ID
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['fine_id']) ?>"
                           readonly>
                </div>

                <!-- Member ID -->
                <div class="mb-3">
                    <label class="form-label small fw-medium">
                        Member ID
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['member_id']) ?>"
                           readonly>
                </div>

                <!-- Member Name -->
                <div class="mb-3">
                    <label class="form-label small fw-medium">
                        Member Name
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['member_name']) ?>"
                           readonly>
                </div>

                <!-- Book ID -->
                <div class="mb-3">
                    <label class="form-label small fw-medium">
                        Book ID
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['book_id']) ?>"
                           readonly>
                </div>

                <!-- Book Name -->
                <div class="mb-3">
                    <label class="form-label small fw-medium">
                        Book Name
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['book_name']) ?>"
                           readonly>
                </div>

                <!-- Fine Amount -->
                <div class="mb-3">
                    <label for="fine_amount" class="form-label small fw-medium">
                        Fine Amount (LKR)
                    </label>

                    <input type="number"
                           class="form-control"
                           id="fine_amount"
                           name="fine_amount"
                           min="2"
                           max="500"
                           step="0.01"
                           value="<?= htmlspecialchars($row['fine_amount']) ?>"
                           required>
                </div>

                <!-- Date Modified -->
                <div class="mb-4">
                    <label class="form-label small fw-medium">
                        Date Modified
                    </label>

                    <input type="text"
                           class="form-control bg-light"
                           value="<?= htmlspecialchars($row['fine_date_modified']) ?>"
                           readonly>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">

                    <button type="submit"
                            name="save"
                            class="btn btn-primary px-4 fw-bold">
                        Save
                    </button>

                    <a href="manage.php"
                       class="btn btn-light px-4">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</main>

<?php include '../../includes/footer.php'; ?>