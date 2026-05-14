<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../../config/database.php';

/* ADD BORROW */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_borrow'])) {

    $borrow_id = trim($_POST['borrow_id'] ?? '');
    $book_id = trim($_POST['book_id'] ?? '');
    $member_id = trim($_POST['member_id'] ?? '');
    $borrow_status = trim($_POST['borrow_status'] ?? '');
    $borrower_date_modified = trim($_POST['borrower_date_modified'] ?? '');

    if ($borrow_id === '' || $book_id === '' || $member_id === '' || $borrow_status === '' || $borrower_date_modified === '') {
        $_SESSION['msg'] = 'All fields are required';
        header('Location: manage.php');
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO bookborrower (borrow_id, book_id, member_id, borrow_status, borrower_date_modified) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $borrow_id, $book_id, $member_id, $borrow_status, $borrower_date_modified);

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Borrow row added successfully';
    } else {
        $_SESSION['msg'] = 'Error adding borrow row: ' . $conn->error;
    }

    header('Location: manage.php');
    exit;
}

/* UPDATE BORROW */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_borrow'])) {

    $borrow_id = trim($_POST['borrow_id'] ?? '');
    $book_id = trim($_POST['book_id'] ?? '');
    $member_id = trim($_POST['member_id'] ?? '');
    $borrow_status = trim($_POST['borrow_status'] ?? '');
    $borrower_date_modified = trim($_POST['borrower_date_modified'] ?? '');

    if ($borrow_id === '' || $book_id === '' || $member_id === '' || $borrow_status === '' || $borrower_date_modified === '') {
        $_SESSION['msg'] = 'All fields are required';
        header('Location: manage.php');
        exit;
    }

    $stmt = $conn->prepare("UPDATE bookborrower
                            SET book_id = ?, member_id = ?, borrow_status = ?, borrower_date_modified = ?
                            WHERE borrow_id = ?");
    $stmt->bind_param('sssss', $book_id, $member_id, $borrow_status, $borrower_date_modified, $borrow_id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = 'Borrow row updated successfully';
    } else {
        $_SESSION['msg'] = 'Error updating borrow row: ' . $conn->error;
    }

    header('Location: manage.php');
    exit;
}

/* DELETE BORROW */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_borrow'])) {

    $borrow_id = trim($_POST['borrow_id'] ?? '');
    $book_id = trim($_POST['book_id'] ?? '');
    $member_id = trim($_POST['member_id'] ?? '');

    if ($borrow_id !== '' && $book_id !== '' && $member_id !== '') {
        $stmt = $conn->prepare('DELETE FROM bookborrower WHERE borrow_id = ? AND book_id = ? AND member_id = ?');
        $stmt->bind_param('sss', $borrow_id, $book_id, $member_id);

        if ($stmt->execute()) {
            $_SESSION['msg'] = 'Borrow row deleted';
        } else {
            $_SESSION['msg'] = 'Error deleting borrow row: ' . $conn->error;
        }
    } else {
        $_SESSION['msg'] = 'Invalid delete request';
    }

    header('Location: manage.php');
    exit;
}

$page_title = 'Borrow';
include '../../includes/header.php';
include '../../includes/sidebar.php';
?>

<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>

    <div class="page-content">
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-success py-2 px-3">
                <?php echo htmlspecialchars($_SESSION['msg']); ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Borrow</h4>
            <a href="create.php" class="btn btn-primary px-4 fw-bold">Add</a>
        </div>

        <div class="lms-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold border-0">Book ID</th>
                            <th class="fw-semibold border-0">Member Who Borrowed</th>
                            <th class="fw-semibold border-0">Book Name</th>
                            <th class="fw-semibold border-0">Borrow Status</th>
                            <th class="fw-semibold border-0">Date Modified</th>
                            <th class="fw-semibold border-0 text-end rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php
                        $query = "SELECT bb.borrow_id, bb.book_id, bb.member_id, bb.borrow_status, bb.borrower_date_modified,
                                         b.book_name, m.first_name, m.last_name
                                  FROM bookborrower bb
                                  JOIN book b ON bb.book_id = b.book_id
                                  JOIN member m ON bb.member_id = m.member_id
                                  ORDER BY bb.borrower_date_modified DESC";

                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['book_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                <td>
                                    <?php if ($row['borrow_status'] === 'borrowed'): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 rounded-pill">Borrowed</span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 rounded-pill">Available</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
    <?php echo !empty($row['borrower_date_modified'])
        ? htmlspecialchars(date('d M Y, h:i A', strtotime($row['borrower_date_modified'])))
        : '-'; ?>
</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="edit.php?id=<?php echo urlencode($row['borrow_id']); ?>"
                                           class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                            <span class="material-symbols-outlined" style="font-size: 1rem;">edit</span>
                                        </a>

                                        <a href="view.php?id=<?php echo urlencode($row['borrow_id']); ?>"
                                           class="btn btn-sm btn-outline-info d-flex align-items-center">
                                            <span class="material-symbols-outlined" style="font-size: 1rem;">visibility</span>
                                        </a>

                                        <form method="POST" class="m-0" onsubmit="return confirm('Delete this row?');">
                                            <input type="hidden" name="delete_borrow" value="1">
                                            <input type="hidden" name="borrow_id" value="<?php echo htmlspecialchars($row['borrow_id']); ?>">
                                            <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($row['book_id']); ?>">
                                            <input type="hidden" name="member_id" value="<?php echo htmlspecialchars($row['member_id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                                <span class="material-symbols-outlined" style="font-size: 1rem;">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include '../../includes/footer.php'; ?>