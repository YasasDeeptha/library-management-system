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
    <title>View Staff Member | LMS</title>
    <link rel="icon" href="/library-management-system/assets/images/book.png" type="image/png">

    <link rel="stylesheet" href="/library-management-system/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/library-management-system/assets/css/style.css">
</head>

<body class="bg-light">

<div class="container py-5" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Staff Profile</h2>
            <p class="text-muted mb-0">View staff account details</p>
        </div>

        <a href="manage.php" class="btn btn-light px-4 py-2 fw-semibold rounded-3 border">
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex align-items-center gap-4 mb-5">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm"
                     style="width:90px;height:90px;font-size:32px;font-weight:700;">
                    <?= strtoupper(substr($user['first_name'], 0, 1)); ?>
                </div>

                <div>
                    <h3 class="fw-bold mb-1">
                        <?= htmlspecialchars($user['first_name']); ?>
                        <?= htmlspecialchars($user['last_name']); ?>
                    </h3>

                    <p class="text-muted mb-0">
                        Library Staff Member
                    </p>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">User ID</label>
                        <div class="fw-semibold fs-5">
                            <?= htmlspecialchars($user['user_id']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">Username</label>
                        <div class="fw-semibold fs-5">
                            <?= htmlspecialchars($user['username']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">First Name</label>
                        <div class="fw-semibold fs-5">
                            <?= htmlspecialchars($user['first_name']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">Last Name</label>
                        <div class="fw-semibold fs-5">
                            <?= htmlspecialchars($user['last_name']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">Email Address</label>
                        <div class="fw-semibold fs-5">
                            <?= htmlspecialchars($user['email']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-4 h-100">
                        <label class="text-muted small mb-2">Status</label>
                        <div>
                            <span class="badge bg-success px-3 py-2">
                                Active
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-top mt-5 pt-4 d-flex gap-2">
                <a href="manage.php" class="btn btn-light px-4 border">
                    Back
                </a>

                <a href="edit.php?id=<?= urlencode($user['user_id']); ?>" class="btn btn-primary px-4">
                    Edit Staff
                </a>
            </div>

        </div>
    </div>

</div>

<script src="/library-management-system/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>