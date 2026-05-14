<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if(!isset($_SESSION['user_id'])){
    header('Location: /library-management-system/index.php');
    exit;
}

include '../../config/database.php';

if(isset($_POST['save'])){

    $fine_id     = mysqli_real_escape_string($conn, trim($_POST['fine_id'] ?? ''));
    $fine_amount = trim($_POST['fine_amount'] ?? '');

    $errors = [];

    // Validation 1 - Fine ID required
    if($fine_id === ''){
        $errors[] = "Fine ID is required.";
    }

    // Validation 2 - Fine amount
    if(!is_numeric($fine_amount) || $fine_amount < 2 || $fine_amount > 500){
        $errors[] = "Fine amount must be between 2 and 500 LKR.";
    }

    // Check record exists
    if(empty($errors)){

        $check_sql = "SELECT * FROM fine WHERE fine_id = '$fine_id'";
        $check_res = mysqli_query($conn, $check_sql);

        if(mysqli_num_rows($check_res) === 0){
            $errors[] = "Fine record not found.";
        }
    }

    // If errors
    if(!empty($errors)){

        $_SESSION['error'] = implode('<br>', $errors);

        header("Location: edit.php?id=" . urlencode($fine_id));
        exit;
    }

    // Update record
    $date = date('Y-m-d H:i:s');

    $update_sql = "UPDATE fine SET
                        fine_amount = '" . mysqli_real_escape_string($conn, $fine_amount) . "',
                        fine_date_modified = '$date'
                   WHERE fine_id = '$fine_id'";

    if(mysqli_query($conn, $update_sql)){

        $_SESSION['success'] = "Fine <strong>$fine_id</strong> updated successfully!";

        header("Location: manage.php");
        exit;

    } else {

        $_SESSION['error'] = "Database Error: " . mysqli_error($conn);

        header("Location: edit.php?id=" . urlencode($fine_id));
        exit;
    }

} else {

    header("Location: manage.php");
    exit;
}
?>