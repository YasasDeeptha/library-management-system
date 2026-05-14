<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
$page_title = 'View Fine';
include '../../includes/header.php'; 
include '../../includes/sidebar.php';
include '../../config/database.php';

$fine_id = mysqli_real_escape_string($conn, trim($_GET['id'] ?? ''));


if($fine_id === ''){
    $_SESSION['error'] = "No Fine ID provided.";
    header("Location: manage.php");
    exit;
}

// Step 3 - Fetch the fine record from DB
$sql = "SELECT f.fine_id, 
               f.member_id,
               CONCAT(m.first_name, ' ', m.last_name) AS member_name,
               f.book_id,
               b.book_name,
               f.fine_amount,
               f.fine_date_modified
        FROM fine f
        JOIN member m ON f.member_id = m.member_id
        JOIN book   b ON f.book_id   = b.book_id
        WHERE f.fine_id = '$fine_id'";

$result = mysqli_query($conn, $sql);
$row    = mysqli_fetch_assoc($result);

// Step 4 - If record not found redirect back
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
                <h5 class="mb-0 fw-bold">Fine</h5>
            </div>
            <div class="mb-3">
    <label class="form-label small fw-medium text-muted">Fine ID</label>
    <div class="fw-medium"><?= htmlspecialchars($row['fine_id']) ?></div>
</div>
            <div class="mb-3">
                <label class="form-label small fw-medium text-muted">Member ID</label>
                <div class="fw-medium"><?= htmlspecialchars($row['member_id']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-medium text-muted">Book ID</label>
                <div class="fw-medium"><?= htmlspecialchars($row['book_id']) ?></div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-medium text-muted">Fine Amount</label>
                <div class="fw-medium"><?= htmlspecialchars($row['fine_amount']) ?></div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-medium text-muted">Date Modified</label>
                <div class="fw-medium"><?= htmlspecialchars($row['fine_date_modified']) ?></div>
            </div>
            <div class="d-flex gap-2 border-top pt-4">
                <a href="manage.php" class="btn btn-light px-4">Back</a>
            </div>
        </div>
    </div>
</main>
<?php include '../../includes/footer.php'; ?>
