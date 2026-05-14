<?php

session_start();

if (!isset($_SESSION['super_admin'])) {
    header("Location: /library-management-system/index.php");
    exit();
}

require_once '../../config/database.php';

$user_id = $_GET['id'] ?? '';

if (empty($user_id)) {
    header("Location: manage.php");
    exit();
}

$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: manage.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Member | LMS</title>
    <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">

    <link rel="stylesheet" href="/library-management-system/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/library-management-system/assets/css/style.css">
</head>

<body class="bg-light">

<div class="container py-5" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Update Staff Member</h2>
            <p class="text-muted mb-0">Edit staff account details</p>
        </div>

        <a href="manage.php" class="btn btn-light px-4 py-2 fw-semibold rounded-3 border">
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <form action="updateprocess.php" method="POST">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-medium">User ID</label>
                        <input type="text"
                               class="form-control bg-light"
                               name="user_id"
                               value="<?= htmlspecialchars($user['user_id']); ?>"
                               readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Username</label>
                        <input type="text"
                               class="form-control"
                               name="username"
                               value="<?= htmlspecialchars($user['username']); ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">First Name</label>
                        <input type="text"
                               class="form-control"
                               name="first_name"
                               value="<?= htmlspecialchars($user['first_name']); ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Last Name</label>
                        <input type="text"
                               class="form-control"
                               name="last_name"
                               value="<?= htmlspecialchars($user['last_name']); ?>"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Email Address</label>
                        <input type="email"
                               class="form-control"
                               name="email"
                               value="<?= htmlspecialchars($user['email']); ?>"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">New Password</label>
                        <input type="password"
                               class="form-control"
                               name="password"
                               placeholder="Leave blank to keep current password">
                        <small class="text-muted">
                            Only enter a password if you want to change it.
                        </small>
                    </div>

                </div>

                <div class="d-flex gap-2 mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        Save Changes
                    </button>

                    <a href="manage.php" class="btn btn-light px-4 border">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<script src="/library-management-system/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>