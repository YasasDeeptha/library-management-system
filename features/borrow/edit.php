<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../config/database.php';

$page_title = 'Edit Borrow';

include '../../includes/header.php';
include '../../includes/sidebar.php';

$borrow_id = $_GET['id'] ?? '';

$row = [
    'borrow_id' => '',
    'book_id' => '',
    'member_id' => '',
    'borrow_status' => '',
    'borrower_date_modified' => ''
];

if ($borrow_id !== '') {

    $stmt = $conn->prepare("
        SELECT borrow_id, book_id, member_id, borrow_status, borrower_date_modified
        FROM bookborrower
        WHERE borrow_id = ?
        LIMIT 1
    ");

    $stmt->bind_param('s', $borrow_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $_SESSION['msg'] = 'Borrow record not found';
        header('Location: manage.php');
        exit;
    }
}

$books = $conn->query("
    SELECT book_id, book_name
    FROM book
    ORDER BY book_id
");

$members = $conn->query("
    SELECT member_id, first_name, last_name
    FROM member
    ORDER BY member_id
");

?>

<main class="main-content">

    <?php include '../../includes/navbar.php'; ?>

    <div class="page-content">

        <div class="lms-card">

            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Edit Borrow</h5>
            </div>

            <form action="manage.php" method="POST">

            <input type="hidden" name="update_borrow" value="1">

                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <label for="borrow_id"
                               class="form-label small fw-medium">

                            Borrow ID

                        </label>

                        <input type="text"
                               class="form-control bg-light"
                               id="borrow_id"
                               name="borrow_id"
                               value="<?php echo htmlspecialchars($row['borrow_id']); ?>"
                               readonly>

                    </div>

                    <div class="col-md-6">

                        <label for="borrow_status"
                               class="form-label small fw-medium">

                            Status

                        </label>

                        <select class="form-select"
                                id="borrow_status"
                                name="borrow_status"
                                required>

                            <option value=""
                                    disabled
                                    <?php echo $row['borrow_status'] === '' ? 'selected' : ''; ?>>

                                Select status

                            </option>

                            <option value="borrowed"
                                <?php echo $row['borrow_status'] === 'borrowed' ? 'selected' : ''; ?>>

                                Borrowed

                            </option>

                            <option value="available"
                                <?php echo $row['borrow_status'] === 'available' ? 'selected' : ''; ?>>

                                Available

                            </option>

                        </select>

                    </div>

                </div>


                <div class="row g-3 mb-3">

                    <div class="col-md-6">

                        <label for="book_id"
                               class="form-label small fw-medium">

                            Book

                        </label>

                        <select class="form-select"
                                id="book_id"
                                name="book_id"
                                required>

                            <option value=""
                                    disabled>

                                Select book

                            </option>

                            <?php if ($books && $books->num_rows > 0): ?>

                                <?php while ($book = $books->fetch_assoc()): ?>

                                    <option value="<?php echo htmlspecialchars($book['book_id']); ?>"
                                        <?php echo $row['book_id'] === $book['book_id'] ? 'selected' : ''; ?>>

                                        <?php
                                        echo htmlspecialchars(
                                            $book['book_id'] . ' - ' . $book['book_name']
                                        );
                                        ?>

                                    </option>

                                <?php endwhile; ?>

                            <?php endif; ?>

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label for="member_id"
                               class="form-label small fw-medium">

                            Member

                        </label>

                        <select class="form-select"
                                id="member_id"
                                name="member_id"
                                required>

                            <option value=""
                                    disabled>

                                Select member

                            </option>

                            <?php if ($members && $members->num_rows > 0): ?>

                                <?php while ($member = $members->fetch_assoc()): ?>

                                    <option value="<?php echo htmlspecialchars($member['member_id']); ?>"
                                        <?php echo $row['member_id'] === $member['member_id'] ? 'selected' : ''; ?>>

                                        <?php
                                        echo htmlspecialchars(
                                            $member['member_id'] . ' - ' .
                                            $member['first_name'] . ' ' .
                                            $member['last_name']
                                        );
                                        ?>

                                    </option>

                                <?php endwhile; ?>

                            <?php endif; ?>

                        </select>

                    </div>

                </div>

                <div class="mb-4">

                    <label for="borrower_date_modified"
                           class="form-label small fw-medium">

                        Date Modified

                    </label>

                    <input type="datetime-local"
                           class="form-control"
                           id="borrower_date_modified"
                           name="borrower_date_modified"
                           value="<?php
                                echo !empty($row['borrower_date_modified'])
                                    ? htmlspecialchars(
                                        date(
                                            'Y-m-d\TH:i',
                                            strtotime($row['borrower_date_modified'])
                                        )
                                    )
                                    : date('Y-m-d\TH:i');
                           ?>"
                           required>


                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary px-4 fw-bold">

                        Save Changes

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