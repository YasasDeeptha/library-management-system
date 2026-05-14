<?php

if(session_status() === PHP_SESSION_NONE) session_start();

include '../../config/database.php';

if(isset($_POST['save'])){

    $fine_id            = trim($_POST['fine_id'] ?? '');
    $member_id          = trim($_POST['member_id'] ?? '');
    $book_id            = trim($_POST['book_id'] ?? '');
    $fine_amount        = trim($_POST['fine_amount'] ?? '');
    $fine_date_modified = trim($_POST['fine_date_modified'] ?? '');

    $errors = [];

    // Fine ID validation
    if(!preg_match('/^F\d{3,}$/', $fine_id)){
        $errors[] = "Fine ID must follow format F001.";
    }

    // Member validation
    if($member_id === ''){
        $errors[] = "Member is required.";
    }

    // Book validation
    if($book_id === ''){
        $errors[] = "Book is required.";
    }

    // Fine amount validation
    if(!is_numeric($fine_amount) || $fine_amount < 2 || $fine_amount > 500){
        $errors[] = "Fine amount must be between 2 and 500 LKR.";
    }

    // Date validation
    if($fine_date_modified === ''){
        $errors[] = "Date Modified is required.";
    }

    // Check duplicate Fine ID
    if(empty($errors)){

        $check_fine = "SELECT fine_id
                       FROM fine
                       WHERE fine_id = '" . mysqli_real_escape_string($conn, $fine_id) . "'";

        $check_result = mysqli_query($conn, $check_fine);

        if(mysqli_num_rows($check_result) > 0){
            $errors[] = "Fine ID already exists.";
        }
    }

    // Check duplicate member + book fine
    if(empty($errors)){

        $duplicate_sql = "SELECT *
                          FROM fine
                          WHERE member_id = '" . mysqli_real_escape_string($conn, $member_id) . "'
                          AND book_id = '" . mysqli_real_escape_string($conn, $book_id) . "'";

        $duplicate_result = mysqli_query($conn, $duplicate_sql);

        if(mysqli_num_rows($duplicate_result) > 0){
            $errors[] = "This fine already exists for the selected member and book.";
        }
    }

    // Insert
    if(empty($errors)){

        $sql = "INSERT INTO fine
                (
                    fine_id,
                    member_id,
                    book_id,
                    fine_amount,
                    fine_date_modified
                )
                VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            'sssds',
            $fine_id,
            $member_id,
            $book_id,
            $fine_amount,
            $fine_date_modified
        );

        if(mysqli_stmt_execute($stmt)){

            $_SESSION['success'] = "Fine added successfully.";

            header("Location: manage.php");
            exit;

        } else {

            $_SESSION['error'] = "Database Error: " . mysqli_error($conn);

            header("Location: create.php");
            exit;
        }

    } else {

        $_SESSION['error'] = implode('<br>', $errors);

        header("Location: create.php");
        exit;
    }

} else {

    header("Location: create.php");
    exit;
}
?>