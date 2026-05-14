<?php

session_start();
//Delete book from database
    include '../../config/database.php';

    if($_SERVER['REQUEST_METHOD']=='GET'){
        $book_id = $_GET['id'];

        $check_sql = "SELECT * FROM bookborrower WHERE book_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, 's', $book_id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        
        if(mysqli_num_rows($result) > 0){
            echo "<script>alert('Book already borrowed!');window.location='../books/manage.php'</script>";
            exit();
        }

        $fine_check_sql = "SELECT * FROM fine WHERE book_id = ?";
        $fine_check_stmt = mysqli_prepare($conn, $fine_check_sql);
        mysqli_stmt_bind_param($fine_check_stmt, 's', $book_id);
        mysqli_stmt_execute($fine_check_stmt);
        $fine_result = mysqli_stmt_get_result($fine_check_stmt);

        if(mysqli_num_rows($fine_result) > 0){
            echo "<script>alert('Book cannot be deleted because fines still use it!');window.location='../books/manage.php'</script>";
            exit();
        }

        $sql = "DELETE FROM book WHERE book_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $book_id);
        
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['success'] = "Book deleted successfully!";
        }else{
            $_SESSION['error'] = "Failed to delete book. Please try again.";
       }

    header("location: ../books/manage.php");


        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        exit();
    }else{
        echo "<script>alert('Invalid request!');window.location='../books/manage.php'</script>";
        exit();
    }

?>