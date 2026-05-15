<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once 'config/database.php';

$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$username = $_SESSION['username'] ?? '';
$displayName = trim($firstName . ' ' . $lastName);

if ($displayName === '') {
    $displayName = $username !== '' ? $username : 'staff member';
}

function getCount(mysqli $conn, string $table): int {
    $result = $conn->query("SELECT COUNT(*) AS total FROM {$table}");
    if ($result) {
        $row = $result->fetch_assoc();
        return (int) ($row['total'] ?? 0);
    }

    return 0;
}

$stats = [
    ['title' => 'Users', 'value' => getCount($conn, 'user'), 'link' => 'features/auth/manage.php'],
    ['title' => 'Books', 'value' => getCount($conn, 'book'), 'link' => 'features/books/manage.php'],
    ['title' => 'Categories', 'value' => getCount($conn, 'bookcategory'), 'link' => 'features/categories/manage.php'],
    ['title' => 'Members', 'value' => getCount($conn, 'member'), 'link' => 'features/members/manage.php'],
    ['title' => 'Borrow', 'value' => getCount($conn, 'bookborrower'), 'link' => 'features/borrow/manage.php'],
    ['title' => 'Fines', 'value' => getCount($conn, 'fine'), 'link' => 'features/fines/manage.php'],
];

?>


<?php 
include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include 'includes/navbar.php'; ?>
    <div class="page-content">
        <div class="lms-card mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="mb-1 fw-bold">Library dashboard</h4>
                    <div class="text-muted">Welcome, <?php echo htmlspecialchars($displayName); ?></div>
                </div>
                <div class="text-muted small">
                    <?php echo date('d M Y'); ?>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <?php foreach ($stats as $stat): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="<?php echo htmlspecialchars($stat['link']); ?>" class="text-decoration-none text-dark">
                        <div class="lms-card h-100">
                            <div class="text-muted small mb-2"><?php echo htmlspecialchars($stat['title']); ?></div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="fs-2 fw-bold"><?php echo $stat['value']; ?></div>
                                <div class="text-primary fw-semibold">Open</div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</main>
<?php include 'includes/footer.php'; ?>
