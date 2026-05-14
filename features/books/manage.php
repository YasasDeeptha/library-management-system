<?php 
if(session_status() === PHP_SESSION_NONE) session_start();


$page_title = 'Manage Books';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
include '../../config/database.php';


//success messages
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$sql = "SELECT b.book_id, b.book_name, b.category_id, c.category_Name 
        FROM book b 
        JOIN bookcategory c ON b.category_id = c.category_id";
$books = mysqli_query($conn, $sql);
?>

<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 fw-bold">Books</h4>
                <button type="button" class="btn btn-primary btn-sm px-3" onclick="new bootstrap.Modal(document.getElementById('addBookModal')).show()">Add</button>
            </div>
        <div class="lms-card">

            <!-- Success alert-->
            <?php if($success): ?>
                <div class="alert alert-success alert-dismissible fade show" id="successAlert">
                      <?= htmlspecialchars($success) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <script>
             setTimeout(function() {
                    bootstrap.Alert.getOrCreateInstance(
                    document.getElementById('successAlert')
                    ).close();
                }, 3000);
            </script>
<?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold border-0">Book ID</th>
                            <th class="fw-semibold border-0">Book Name</th>
                            <th class="fw-semibold border-0">Book Category</th>
                            <th class="fw-semibold border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if(mysqli_num_rows($books) > 0): ?>
                            <?php while($book = mysqli_fetch_assoc($books)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($book['book_id']) ?></td>
                                    <td><?= htmlspecialchars($book['book_name']) ?></td>
                                    <td><?= htmlspecialchars($book['category_Name']) ?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick='openEditModal(<?= json_encode($book['book_id']) ?>, <?= json_encode($book['book_name']) ?>, <?= json_encode($book['category_id']) ?>)'>Edit</button>
                                        <a href="delete_book.php?id=<?= $book['book_id'] ?>" 
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Add Book Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="add_book.php" method="POST">
                    <div class="modal-body">
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Book ID</label>
                            <input type="text" class="form-control" name="book_id" placeholder="Ex: B001"
                                pattern="B\d{3,}" title="Must start with B followed by numbers (e.g., B001)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Book Name</label>
                            <input type="text" class="form-control" name="book_name" placeholder="Enter book name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Category</label>
                            <select class="form-select" name="category_id" required>
                                <?php
                                    $cat_sql = "SELECT category_id, category_Name FROM bookcategory";
                                    $cat_result = mysqli_query($conn, $cat_sql);
                                    while($cat = mysqli_fetch_assoc($cat_result)):
                                ?>
                                    <option value="<?= $cat['category_id'] ?>">
                                        <?= htmlspecialchars($cat['category_Name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="edit_book.php" method="POST">
                    <div class="modal-body">
                        <?php if(isset($_GET['edit_error'])): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($_GET['edit_error']) ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Book ID</label>
                            <input type="text" class="form-control bg-light" name="book_id" id="edit_book_id" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Book Name</label>
                            <input type="text" class="form-control" name="book_name" id="edit_book_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-medium">Category</label>
                            <select class="form-select" name="category_id" id="edit_category_id" required>
                                <?php
                                    // Reset the category query result pointer
                                    mysqli_data_seek($cat_result, 0);
                                    while($cat = mysqli_fetch_assoc($cat_result)):
                                ?>
                                    <option value="<?= $cat['category_id'] ?>">
                                        <?= htmlspecialchars($cat['category_Name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold" onclick='return confirm("Are you sure you want to update the book data?")'>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(bookId, bookName, categoryId) {
            console.log("Opening edit modal with:", bookId, bookName, categoryId);
            
            document.getElementById('edit_book_id').value = bookId;
            document.getElementById('edit_book_name').value = bookName;
            document.getElementById('edit_category_id').value = categoryId;
            
            var modalElement = document.getElementById('editBookModal');
            

                if (modalElement) {
                    var modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } else {
                    console.error("Modal element not found!");
                }

            }
        


        <?php if(isset($_GET['error'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal(document.getElementById('addBookModal')).show();
            });
        <?php endif; ?>

        <?php if(isset($_GET['edit_error'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal(document.getElementById('editBookModal')).show();
            });
        <?php endif; ?>
        
        
    </script>
</main>

<?php include '../../includes/footer.php'; ?>