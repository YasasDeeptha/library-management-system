<?php 
if(session_status() === PHP_SESSION_NONE) session_start();

$page_title = 'Add Fine';

include '../../config/database.php';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 

// Fetch Members
$member_sql = "SELECT member_id, first_name, last_name 
               FROM member
               ORDER BY member_id ASC";

$member_result = mysqli_query($conn, $member_sql);

// Fetch Books
$book_sql = "SELECT book_id, book_name
             FROM book
             ORDER BY book_id ASC";

$book_result = mysqli_query($conn, $book_sql);
?>

<main class="main-content">

    <?php include '../../includes/navbar.php'; ?>

    <div class="page-content">

        <div class="lms-card">

            <div class="mb-4">
                <h5 class="mb-0 fw-bold">Add Fine</h5>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="b_enter.php" method="POST">

                <!-- Fine ID -->
                <div class="mb-3">

                    <label for="fine_id"
                           class="form-label small fw-medium">
                        Fine ID
                    </label>

                    <input type="text"
                           class="form-control"
                           id="fine_id"
                           name="fine_id"
                           placeholder="Example: F001"
                           required>

                </div>

                <!-- Member -->
                <div class="mb-3">

                    <label for="member_id"
                           class="form-label small fw-medium">
                        Member
                    </label>

                    <select class="form-select"
                            id="member_id"
                            name="member_id"
                            required>

                        <option value="" selected disabled>
                            Select Member
                        </option>

                        <?php while($member = mysqli_fetch_assoc($member_result)): ?>

                            <option value="<?= htmlspecialchars($member['member_id']) ?>">

                                <?= htmlspecialchars($member['member_id']) ?>
                                -
                                <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <!-- Book -->
                <div class="mb-3">

                    <label for="book_id"
                           class="form-label small fw-medium">
                        Book
                    </label>

                    <select class="form-select"
                            id="book_id"
                            name="book_id"
                            required>

                        <option value="" selected disabled>
                            Select Book
                        </option>

                        <?php while($book = mysqli_fetch_assoc($book_result)): ?>

                            <option value="<?= htmlspecialchars($book['book_id']) ?>">

                                <?= htmlspecialchars($book['book_id']) ?>
                                -
                                <?= htmlspecialchars($book['book_name']) ?>

                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <!-- Fine Amount -->
                <div class="mb-3">

                    <label for="fine_amount"
                           class="form-label small fw-medium">
                        Fine Amount (LKR)
                    </label>

                    <input type="number"
                           class="form-control"
                           id="fine_amount"
                           name="fine_amount"
                           min="2"
                           max="500"
                           step="0.01"
                           required>

                </div>

                <!-- Date Modified -->
                <div class="mb-4">

                    <label for="fine_date_modified"
                           class="form-label small fw-medium">
                        Date Modified
                    </label>

                    <input type="datetime-local"
                           class="form-control"
                           id="fine_date_modified"
                           name="fine_date_modified"
                           required>

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