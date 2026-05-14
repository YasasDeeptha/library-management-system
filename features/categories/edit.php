<?php
include "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $category_id   = trim($_POST['category_id']);
    $category_name = $_POST['category_name'];
    $date_modified = date('Y-m-d H:i:s');

    
    if (empty($category_id) || empty($category_name)) {
        echo "<script>alert('Fields can not be empty!');
        window.location='manage.php';</script>";
        exit();
    }

    
    $sql = "UPDATE bookcategory SET category_Name='$category_name', date_modified='$date_modified' WHERE category_id='$category_id'"; 

    $stmt = $conn->prepare("UPDATE bookcategory SET category_Name=?, date_modified=? WHERE category_id=?");
    $stmt->bind_param("sss", $category_name, $date_modified, $category_id);
    
    $result = $stmt->execute();

    if ($result) {
        echo "<script>alert('Category Updated Successfully!');
        window.location='manage.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error! " . mysqli_error($conn) . "');
        window.location='manage.php';</script>";
        exit();
    }
}
?>