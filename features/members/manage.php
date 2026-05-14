<?php 

require_once '../../config/database.php'; 

if(session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    
    if (isset($_POST['update'])) {
        $sql = "UPDATE member SET first_name = ?, last_name = ?, birthday = ?, email = ? WHERE member_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $first_name, $last_name, $birthday, $email, $member_id);
    } else {
        $sql = "INSERT INTO member (member_id, first_name, last_name, birthday, email)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $member_id, $first_name, $last_name, $birthday, $email);
    }
    $stmt->execute();
    
    header("Location: manage.php");
    exit();
}

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$result = $conn->query("SELECT * FROM member");

$page_title = 'Manage Members';
include '../../includes/header.php'; 
include '../../includes/sidebar.php'; 
?>
<main class="main-content">
    <?php include '../../includes/navbar.php'; ?>
    <div class="page-content">
        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Members</h4>
            <a href="create.php" class="btn btn-primary px-4 fw-bold">Add Member</a>
        </div>
        <div class="lms-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="fw-semibold border-0 rounded-start">Member ID</th>
                            <th class="fw-semibold border-0">First Name</th>
                            <th class="fw-semibold border-0">Last Name</th>
                            <th class="fw-semibold border-0">Birthday</th>
                            <th class="fw-semibold border-0">Email</th>
                            <th class="fw-semibold border-0 text-end rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['member_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['birthday']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="text-end">
                                        <a href="view.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="edit.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                        <a href="delete.php?id=<?php echo $row['member_id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
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
