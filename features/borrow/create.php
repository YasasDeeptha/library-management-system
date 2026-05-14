<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../../config/database.php';

$page_title = 'Add Borrow';
include '../../includes/header.php';
include '../../includes/sidebar.php';

$books = $conn->query("SELECT book_id, book_name FROM book ORDER BY book_id");
$members = $conn->query("SELECT member_id, first_name, last_name FROM member ORDER BY member_id");
?>

<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>

    <div class="page-content">
        <div class="lms-card">
            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Add Borrow</h5>
            </div>

            <form action="" method="POST">
                <input type="hidden" name="add_borrow" value="1">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="borrow_id" class="form-label small fw-medium">Borrow ID</label>
                        <input
                            type="text"
                            class="form-control"
                            id="borrow_id"
                            name="borrow_id"
                            placeholder="BR001"
                            pattern="BR\d{3,}"
                            title="Format should be BR001, BR002, etc."
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="borrow_status" class="form-label small fw-medium">Status</label>
                        <select class="form-select" id="borrow_status" name="borrow_status" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="borrowed">Borrowed</option>
                            <option value="available">Available</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="book_id" class="form-label small fw-medium">Book</label>
                        <select class="form-select" id="book_id" name="book_id" required>
                            <option value="" disabled selected>Select book</option>
                            <?php if ($books && $books->num_rows > 0): ?>
                                <?php while ($book = $books->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($book['book_id']); ?>">
                                        <?php echo htmlspecialchars($book['book_id'] . ' - ' . $book['book_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="member_id" class="form-label small fw-medium">Member</label>
                        <select class="form-select" id="member_id" name="member_id" required>
                            <option value="" disabled selected>Select member</option>
                            <?php if ($members && $members->num_rows > 0): ?>
                                <?php while ($member = $members->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($member['member_id']); ?>">
                                        <?php echo htmlspecialchars($member['member_id'] . ' - ' . $member['first_name'] . ' ' . $member['last_name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="borrower_date_modified" class="form-label small fw-medium">Date Modified</label>
                    <input
                        type="datetime-local"
                        class="form-control"
                        id="borrower_date_modified"
                        name="borrower_date_modified"
                        value="<?php echo date('Y-m-d\TH:i'); ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary px-4 fw-bold">Save</button>
            </form>
        </div>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>