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

$page_title = 'Edit Member';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="lms-card">
            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Update Member</h5>
            </div>
            <form action="manage.php" method="POST">
                <input type="hidden" name="update" value="1">
                <div class="mb-3">
                    <label for="member_id" class="form-label small fw-medium">Member ID</label>
                    <input type="text" class="form-control bg-light" id="member_id" name="member_id" value="<?php echo htmlspecialchars($member['member_id']); ?>" readonly>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="first_name" class="form-label small fw-medium">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="last_name" class="form-label small fw-medium">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label small fw-medium">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($member['birthday']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label small fw-medium">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Save</button>
                    <a href="manage.php" class="btn btn-light px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include '../../includes/footer.php'; ?>
