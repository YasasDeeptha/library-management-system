<?php
require_once '../../config/database.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $member_id = $_GET['id'];

    $borrow_check = $conn->prepare("SELECT 1 FROM bookborrower WHERE member_id = ? LIMIT 1");
    $borrow_check->bind_param("s", $member_id);
    $borrow_check->execute();
    $borrow_result = $borrow_check->get_result();

    if ($borrow_result->num_rows > 0) {
        $_SESSION['error'] = "Member cannot be deleted because borrow records still use it.";
        header("Location: manage.php");
        exit();
    }

    $fine_check = $conn->prepare("SELECT 1 FROM fine WHERE member_id = ? LIMIT 1");
    $fine_check->bind_param("s", $member_id);
    $fine_check->execute();
    $fine_result = $fine_check->get_result();

    if ($fine_result->num_rows > 0) {
        $_SESSION['error'] = "Member cannot be deleted because fines still use it.";
        header("Location: manage.php");
        exit();
    }

    // Prepare delete query
    $sql = "DELETE FROM member WHERE member_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $member_id);
        $stmt->execute();

        $stmt->close();
    }
}

header("Location: manage.php");
exit();
?>

