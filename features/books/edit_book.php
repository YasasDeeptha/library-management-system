<?php
    include '../../config/database.php';

    
    session_start();


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $book_id = trim($_POST['book_id']);
        $book_name = trim($_POST['book_name']);
        $category = $_POST['category_id'];

        if(empty($book_id) || empty($book_name) || empty($category)){
            echo "<script>alert('Input fields cannot be empty!');
            window.location = 'edit_book.html?book_id={$book_id}'</script>";
            exit();
        }

        if(!preg_match('/^B\d+$/', $book_id)){
            echo "<script>alert('Invalid BookID');window.location= 'edit_book.html?book_id={$book_id}'</script>";
            exit();
        }

        $sql = "UPDATE book SET book_name=?, category_id=? WHERE book_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $book_name,$category,$book_id);
        
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['success'] = "Book updated successfully";
        }else{
            $_SESSION['error'] = "Failed to update book. Please try again.";
       }        

       header('location:../books/manage.php');

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        exit();
    }else{
        echo "<script>alert('Invalid request!');window.location='../books/manage.php'</script>";
        exit();
    }

?>