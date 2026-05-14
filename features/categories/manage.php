<?php

if(session_status() === PHP_SESSION_NONE) session_start();
$page_title = 'Add Category';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 

include "../../config/database.php";


$stmt = $conn->prepare("SELECT * FROM bookcategory ORDER BY category_id ASC");

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Category Registration</title>
    <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Categories</h4>
            <!-- <a href="create.php" class="btn btn-primary px-4 fw-bold">Add Category</a> -->
            <button type="button" class="btn btn-primary px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#addCategoryModal"> Add Category
            </button>

            <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="addCategoryLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body">
                            <form action="create.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Category ID</label>
                                    <input type="text" name="category_id" class="form-control" placeholder="Ex: C001" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
                                </div>
                    
                                <input type="hidden" name="date_modified" value="<?php echo date('Y-m-d H:i:s'); ?>">

                                <div class="mt-4 d-flex gap-2">
                                    <button type="submit" name="save_category" class="btn btn-primary px-4">Save</button>
                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lms-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold border-0 rounded-start">Category ID</th>
                            <th class="fw-semibold border-0">Category Name</th>
                            <th class="fw-semibold border-0">Date Modified</th>
                            <th class="fw-semibold border-0 text-end rounded-end" style="padding-right: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['category_id']) ?></td>
                            <td><?= htmlspecialchars($row['category_Name']) ?></td>
                            <td><?= htmlspecialchars($row['date_modified']) ?></td>
                            <td class="text-end rounded-end">

                                <!-- Edit Button -->
                                <div class="d-inline-flex gap-2">
                                    <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCategoryModal"
                                        onclick="fillEditModal(
                                        '<?= $row['category_id'] ?>',
                                        '<?= htmlspecialchars($row['category_Name'], ENT_QUOTES) ?>')">
                                        Edit
                                    </button>

                                <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title fw-bold">Update Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                                <div class="modal-body">
                                                    <form action="edit.php" method="POST">
                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-semibold">Category ID</label>
                                                            <input type="text" name="category_id" id="edit_category_id" class="form-control bg-light" readonly>
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label class="form-label fw-semibold">Category Name</label>
                                                            <input type="text" name="category_name" id="edit_category_name" class="form-control" required>
                                                        </div>
                    
                                                        <div class="mt-4 d-flex gap-2">
                                                            <button type="submit" name="update_category" class="btn btn-primary px-4">Update Changes</button>
                                                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Button -->
                                    <a href="delete.php?id=<?= $row['category_id'] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                        Delete
                                    </a>
                                </div>
                        
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No categories found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>





<script>
function fillEditModal(id, name) {
    // Find the inputs by their IDs and set their values
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_category_name').value = name;
}
</script>

<?php include '../../includes/footer.php'; ?>
