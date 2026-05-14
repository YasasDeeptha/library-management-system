<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
$page_title = 'Add Member';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="lms-card">
            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Add Member</h5>
            </div>
            <form action="manage.php" method="POST">
                <div class="mb-3">
                    <label for="member_id" class="form-label small fw-medium">Member ID</label>
                    <input type="text" class="form-control" id="member_id" name="member_id" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="first_name" class="form-label small fw-medium">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="last_name" class="form-label small fw-medium">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label small fw-medium">Birthday</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label small fw-medium">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
