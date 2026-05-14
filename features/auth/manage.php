<?php

session_start();

if (!isset($_SESSION['super_admin'])) {

    header("Location: /library-management-system/index.php");
    exit();
}

require_once '../../config/database.php';



$sql = "SELECT * FROM user ORDER BY user_id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Super Admin | Staff Management</title>
    <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">

    <link rel="stylesheet"
        href="/library-management-system/assets/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="/library-management-system/assets/css/style.css">

</head>

<body class="bg-light">

    <div class="container py-5">

    
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold mb-1">
                    Staff Management
                </h2>

                <p class="text-muted mb-0">
                    Super Admin Control Panel
                </p>

            </div>

            <div class="d-flex gap-2">

                <button class="btn btn-primary px-4 py-2 fw-semibold rounded-3"
                    data-bs-toggle="modal"
                    data-bs-target="#addStaffModal">

                    Add Staff

                </button>

                <a href="/library-management-system/features/auth/logout.php"
                    class="btn btn-outline-danger px-4 py-2 fw-semibold rounded-3">

                    Logout

                </a>

            </div>

        </div>

      
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

             
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Registered Staff
                        </h5>

                        <small class="text-muted">
                            Manage library staff accounts
                        </small>

                    </div>

                    <div style="width:260px;">

                        <input type="text"
                            class="form-control"
                            id="searchStaff"
                            placeholder="Search staff...">

                    </div>

                </div>

                
                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Email Address</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Actions</th>

                            </tr>

                        </thead>

                        <tbody id="staffTable">

                            <?php if ($result->num_rows > 0): ?>

                                <?php while ($row = $result->fetch_assoc()): ?>

                                    <tr>

                                        
                                        <td>

                                            <span class="badge bg-light text-dark border px-3 py-2 fw-semibold">

                                                <?= $row['user_id']; ?>

                                            </span>

                                        </td>

                                       
                                        <td><?= $row['first_name']; ?></td>

                                        <td><?= $row['last_name']; ?></td>

                                        
                                        <td>

                                            <?= $row['username']; ?>

                                        </td>

                                        
                                        <td style="min-width: 180px;">
                                            <div class="d-flex align-items-center gap-2">
                                                <span id="passwordText<?= $row['user_id']; ?>" class="font-monospace text-muted">
                                                    ••••••••
                                                </span>

                                                <button type="button"
                                                    class="btn btn-light btn-sm border"
                                                    onclick="togglePassword(
                    'passwordText<?= $row['user_id']; ?>',
                    '<?= htmlspecialchars(substr($row['password'], 0, 8), ENT_QUOTES); ?>'
                )">
                                                    👁 Show
                                                </button>
                                            </div>
                                        </td>

                                        
                                        <td>

                                            <?= $row['email']; ?>

                                        </td>

                                        <td class="text-center">

                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">

                                                Active

                                            </span>

                                        </td>

                                 
                                        <td>

                                            <div class="d-flex justify-content-end gap-2">

                                                <a href="view.php?id=<?= $row['user_id']; ?>"
                                                    class="btn btn-light btn-sm border">

                                                    View

                                                </a>

                                                <a href="edit.php?id=<?= $row['user_id']; ?>"
                                                    class="btn btn-primary btn-sm">

                                                    Edit

                                                </a>

                                                <a href="delete.php?id=<?= $row['user_id']; ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Delete this user?')">

                                                    Delete

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endwhile; ?>

                            <?php else: ?>

                                <tr>

                                        <td colspan="7"
                                        class="text-center py-5 text-muted">

                                        No staff members found.

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- ADD STAFF MODAL -->

    <div class="modal fade"
        id="addStaffModal"
        tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 shadow">

                <div class="modal-header border-0 pb-0">

                    <div>

                        <h4 class="fw-bold mb-1">
                            Register Staff
                        </h4>

                        <p class="text-muted small mb-0">
                            Create new staff account
                        </p>

                    </div>

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body pt-4">

                    <div class="alert alert-danger d-none"
                        id="staffMessage"></div>

                    <form id="staffForm">

                        <div class="mb-3">

                            <label class="form-label fw-medium">
                                Username
                            </label>

                            <input type="text"
                                class="form-control"
                                id="staff_username"
                                required>

                        </div>

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-medium">
                                    First Name
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="staff_firstname"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-medium">
                                    Last Name
                                </label>

                                <input type="text"
                                    class="form-control"
                                    id="staff_lastname"
                                    required>

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label fw-medium">
                                Email Address
                            </label>

                            <input type="email"
                                class="form-control"
                                id="staff_email"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-medium">
                                Password
                            </label>

                            <input type="password"
                                class="form-control"
                                id="staff_password"
                                required>

                        </div>

                        <button type="submit"
                            class="btn btn-primary w-100 py-2 fw-semibold">

                            Register Staff

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="/library-management-system/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/library-management-system/assets/js/main.js"></script>

</body>

</html>