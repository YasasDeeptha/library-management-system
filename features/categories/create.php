<?php
include "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $category_id   = trim($_POST['category_id'] ?? '');
    $category_name = trim($_POST['category_name'] ?? '');
    $date_modified = date('Y-m-d H:i:s');

    if (empty($category_id) || empty($category_name)) {
        echo "<script>alert('Fields cannot be empty');
        window.location='manage.php';</script>";
        exit();
    }

    if ($category_id[0] !== 'C' || !is_numeric(substr($category_id, 1))) {
        echo "<script>alert('Invalid Category ID! Format should be C001.');
        window.location='manage.php';</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO bookcategory (category_id, category_Name, date_modified) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $category_id, $category_name, $date_modified);

    if ($stmt->execute()) {
        echo "<script>alert('Category Added Successfully!');
        window.location='manage.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error! " . mysqli_error($conn) . "');
        window.location='manage.php';</script>";
        exit();
    }
}
?>