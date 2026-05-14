<?php

session_start();
    //Add book to database
    include '../../config/database.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $book_id = trim($_POST['book_id']);
        $book_name = trim($_POST['book_name']);
        $category = $_POST['category_id'];


        $checksql = "SELECT book_id, book_name FROM book WHERE book_id = '{$book_id}'";

        $checkresult = mysqli_query($conn, $checksql);

        if(mysqli_num_rows($checkresult) > 0){
            echo "<script>alert('Book already exists! Please use a different ID.');
            window.location = '../books/manage.php'</script>";
            exit();
        }
        if(empty($book_id) || empty($book_name) || empty($category)){
            echo "<script>alert('Input fields cannot be empty!');
            window.location = '../books/manage.php'</script>";
            exit();
        }

        if(!preg_match('/^B\d+$/', $book_id)){
            echo "<script>alert('Invalid BookID');window.location= '../books/manage.php'</script>";
            exit();
        }

        $sql = "INSERT INTO book (book_id, book_name, category_id) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $book_id, $book_name, $category);
        
        if(mysqli_stmt_execute($stmt)){
            $_SESSION['success'] = "Book Added Successfully";
        
        }else{
            $_SESSION['error'] = "Failed to Add Book";
       }

        header('location:../books/manage.php');


        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        exit();
    }
?>