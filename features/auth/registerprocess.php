<?php

session_start();

require_once __DIR__ . '/../../config/database.php';
require_once 'sendstaffemail.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid Request";
    exit();
}

if (!isset($_SESSION['super_admin'])) {
    echo "Unauthorized access";
    exit();
}

$username  = trim($_POST['username'] ?? '');
$firstname = trim($_POST['firstname'] ?? '');
$lastname  = trim($_POST['lastname'] ?? '');
$email     = trim($_POST['email'] ?? '');
$password  = trim($_POST['password'] ?? '');



if (
    empty($username) ||
    empty($firstname) ||
    empty($lastname) ||
    empty($email) ||
    empty($password)
) {
    echo "All fields are required";
    exit();
}

if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
    echo "Invalid username format";
    exit();
}

if (!preg_match("/^[a-zA-Z]+$/", $firstname)) {
    echo "Invalid first name";
    exit();
}

if (!preg_match("/^[a-zA-Z]+$/", $lastname)) {
    echo "Invalid last name";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    exit();
}

if (strlen($password) < 8) {
    echo "Password must be at least 8 characters";
    exit();
}


$checkEmail = "SELECT 1 FROM user WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($checkEmail);
$stmt->bind_param("s", $email);
$stmt->execute();
$emailResult = $stmt->get_result();

if ($emailResult->num_rows > 0) {
    echo "Email already exists";
    exit();
}



$checkUsername = "SELECT 1 FROM user WHERE username = ? LIMIT 1";
$stmt = $conn->prepare($checkUsername);
$stmt->bind_param("s", $username);
$stmt->execute();
$usernameResult = $stmt->get_result();

if ($usernameResult->num_rows > 0) {
    echo "Username already exists";
    exit();
}



$getLastID = "SELECT user_id FROM user ORDER BY user_id DESC LIMIT 1";
$result = $conn->query($getLastID);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastID = $row['user_id'];
    $number = (int) substr($lastID, 1);
    $newUserID = "U" . str_pad($number + 1, 3, "0", STR_PAD_LEFT);
} else {
    $newUserID = "U001";
}



$hashedPassword = password_hash($password, PASSWORD_DEFAULT);



$sql = "INSERT INTO user
        (user_id, email, first_name, last_name, username, password)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssss",
    $newUserID,
    $email,
    $firstname,
    $lastname,
    $username,
    $hashedPassword
);

if ($stmt->execute()) {

    

    sendStaffEmail(
        $email,
        $username,
        $password
    );

    echo "success";

} else {

    echo "Registration failed";

}

?>