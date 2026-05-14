<?php 
require_once '../../config/database.php';

if(session_status() === PHP_SESSION_NONE) session_start();

$member = null;
if (isset($_GET['id'])) {
    $member_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM member WHERE member_id = ?");
    $stmt->bind_param("s", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $member = $result->fetch_assoc();
}

if (!$member) {
    header("Location: manage.php");
    exit();
}

$page_title = 'View Member';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="lms-card">
            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Member</h5>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-medium text-muted">Member ID</label>
                <div class="fw-medium"><?php echo htmlspecialchars($member['member_id']); ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted">First Name</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($member['first_name']); ?></div>
                </div>
                <div class="col-6">
                    <label class="form-label small fw-medium text-muted">Last Name</label>
                    <div class="fw-medium"><?php echo htmlspecialchars($member['last_name']); ?></div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-medium text-muted">Birthday</label>
                <div class="fw-medium"><?php echo htmlspecialchars($member['birthday']); ?></div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-medium text-muted">Email</label>
                <div class="fw-medium"><?php echo htmlspecialchars($member['email']); ?></div>
            </div>
            <div class="d-flex gap-2 border-top pt-4">
                <a href="manage.php" class="btn btn-light px-4">Back</a>
            </div>
        </div>
    </div>
</main>
<?php include '../../includes/footer.php'; ?>
