<?php

session_start();

require_once __DIR__ . '/../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid Request";
    exit();
}

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access";
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$password   = trim($_POST['password'] ?? '');

if (empty($first_name) || empty($last_name) || empty($email)) {
    echo "First name, last name and email are required";
    exit();
}

if (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
    echo "Invalid first name";
    exit();
}

if (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
    echo "Invalid last name";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit();
}


$checkEmail = "SELECT user_id FROM user WHERE email = ? AND user_id <> ?";
$stmt = $conn->prepare($checkEmail);
$stmt->bind_param("ss", $email, $user_id);
$stmt->execute();
$emailResult = $stmt->get_result();

if ($emailResult->num_rows > 0) {
    echo "Email already exists";
    exit();
}


if (!empty($password)) {

    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE user
            SET first_name = ?, last_name = ?, email = ?, password = ?
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $hashedPassword, $user_id);

} else {

    $sql = "UPDATE user
            SET first_name = ?, last_name = ?, email = ?
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $user_id);
}

if ($stmt->execute()) {

    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email'] = $email;

    echo "success";

} else {
    echo "Update failed";
}
?>