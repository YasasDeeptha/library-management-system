<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
$page_title = 'Fine';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Fine</h4>
            <a href="create.php" class="btn btn-primary px-4 fw-bold">Add Fine</a>
        </div>
        <div class="lms-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold border-0 rounded-start">Fine ID</th>
                            <th class="fw-semibold border-0">Member ID</th>
                            <th class="fw-semibold border-0">Member Name</th>
                            <th class="fw-semibold border-0">Book Name</th>
                            <th class="fw-semibold border-0">Fine Amount in LKR</th>
                            <th class="fw-semibold border-0">Date Modified</th>
                            <th class="fw-semibold border-0 text-end rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                    <?php
                    include '../../config/database.php';
                    // Fetch all fines with member name and book name
                    $sql = "SELECT f.fine_id, 
                                   f.member_id,
                                   CONCAT(m.first_name, ' ', m.last_name) AS member_name,
                                   b.book_name, 
                                   f.fine_amount, 
                                   f.fine_date_modified
                            FROM fine f
                            JOIN member m ON f.member_id = m.member_id
                            JOIN book   b ON f.book_id   = b.book_id
                            ORDER BY f.fine_date_modified DESC";

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?= htmlspecialchars($row['fine_id']) ?></td>
                                <td><?= htmlspecialchars($row['member_id']) ?></td>
                                <td><?= htmlspecialchars($row['member_name']) ?></td>
                                <td><?= htmlspecialchars($row['book_name']) ?></td>
                                <td><?= number_format($row['fine_amount'], 2) ?></td>
                               <td>
    <?php
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['fine_date_modified']);
        echo $date ? $date->format('d M Y, h:i A') : htmlspecialchars($row['fine_date_modified']);
    ?>
</td>
                                <td class="text-end">
                                    <a href="view.php?id=<?= urlencode($row['fine_id']) ?>" 
                                        class="btn btn-sm btn-info text-white">View</a>
                                    <a href="edit.php?id=<?= urlencode($row['fine_id']) ?>" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= urlencode($row['fine_id']) ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete fine <?= htmlspecialchars($row['fine_id']) ?>?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No records found</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>


<?php include '../../includes/footer.php'; ?>
<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

