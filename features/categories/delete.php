<?php
include "../../config/database.php";

if (isset($_GET['id'])) {
    
    $category_id = trim($_GET['id']);

    $check = mysqli_query($conn, "SELECT * FROM bookcategory WHERE category_id='$category_id'");
    if (mysqli_num_rows($check) == 0) {

        echo "<script>alert('Category not found!');
        window.location='manage.php';</script>";
        exit();
    }

    $child_check = $conn->prepare("SELECT 1 FROM book WHERE category_id = ? LIMIT 1");
    $child_check->bind_param("s", $category_id);
    $child_check->execute();
    $child_result = $child_check->get_result();

    if ($child_result->num_rows > 0) {
        echo "<script>alert('Category cannot be deleted because books still use it!');
        window.location='manage.php';</script>";
        exit();
    }


    $stmt = $conn->prepare("DELETE FROM bookcategory WHERE category_id=?");
    $stmt->bind_param("s", $category_id);

    $result = $stmt->execute();

    if ($result) {

        echo "<script>alert('Category Deleted Successfully!');
        window.location='manage.php';</script>";
        exit();
        
    } else {

        echo "<script>alert('Error! " . mysqli_error($conn) . "');
        window.location='manage.php';</script>";
        exit();
    }
}
?>