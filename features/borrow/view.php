<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../../config/database.php';

$page_title = 'View Borrow';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$borrow_id = $_GET['id'] ?? '';
$row = ['borrow_id' => '', 'book_id' => '', 'member_id' => '', 'borrow_status' => '', 'borrower_date_modified' => '', 'book_name' => '', 'first_name' => '', 'last_name' => ''];

if ($borrow_id !== '') {
    $stmt = $conn->prepare("SELECT bb.borrow_id, bb.book_id, bb.member_id, bb.borrow_status, bb.borrower_date_modified, b.book_name, m.first_name, m.last_name
                            FROM bookborrower bb
                            JOIN book b ON bb.book_id = b.book_id
                            JOIN member m ON bb.member_id = m.member_id
                            WHERE bb.borrow_id = ?
                            LIMIT 1");
    $stmt->bind_param('s', $borrow_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="lms-card">
            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Borrow Details</h5>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Borrow ID</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($row['borrow_id']); ?></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Status</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($row['borrow_status']); ?></div>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Book</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($row['book_id'] . ' - ' . $row['book_name']); ?></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-medium text-muted">Member</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($row['member_id'] . ' - ' . $row['first_name'] . ' ' . $row['last_name']); ?></div>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-medium text-muted">Date</label>
                <div class="fw-medium"><?php echo htmlspecialchars($row['borrower_date_modified']); ?></div>
            </div>
        </div>
    </div>
</main>
<?php include '../../includes/footer.php'; ?>
