<?php
session_start();
include '../../config/database.php';


$fine_id = mysqli_real_escape_string($conn, trim($_GET['id'] ?? ''));


if($fine_id === ''){
    $_SESSION['error'] = "No Fine ID provided.";
    header("Location: manage.php");
    exit;
}

// Step 3 - Check if record exists in DB
$check = mysqli_query($conn, "SELECT fine_id FROM fine WHERE fine_id = '$fine_id'");
if(mysqli_num_rows($check) == 0){
    $_SESSION['error'] = "Fine not found.";
    header("Location: manage.php");
    exit;
}


$sql = "DELETE FROM fine WHERE fine_id = '$fine_id'";

if(mysqli_query($conn, $sql)){
    $_SESSION['success'] = "Fine $fine_id deleted successfully!";
    header("Location: manage.php");
    exit;
} else {
    $_SESSION['error'] = "Failed to delete. " . mysqli_error($conn);
    header("Location: manage.php");
    exit;
}
?>