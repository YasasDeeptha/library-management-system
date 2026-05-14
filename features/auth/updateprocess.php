<?php

session_start();

require_once '../../config/database.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_id = trim($_POST['user_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    if(
        empty($user_id) ||
        empty($first_name) ||
        empty($last_name) ||
        empty($username) ||
        empty($email)
    ){

        die("All required fields must be filled");

    }


    if(!preg_match("/^U[0-9]{3}$/", $user_id)){

        die("Invalid User ID format");

    }


    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        die("Invalid email format");

    }



    if(!empty($password)){

        if(strlen($password) < 8){

            die("Password must be at least 8 characters");

        }

        $hashedPassword =
            password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE user
                SET
                first_name = ?,
                last_name = ?,
                username = ?,
                email = ?,
                password = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "ssssss",
            $first_name,
            $last_name,
            $username,
            $email,
            $hashedPassword,
            $user_id
        );

    }



    else{

        $sql = "UPDATE user
                SET
                first_name = ?,
                last_name = ?,
                username = ?,
                email = ?
                WHERE user_id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $first_name,
            $last_name,
            $username,
            $email,
            $user_id
        );

    }

    if($stmt->execute()){

        header("Location: manage.php");
        exit();

    }else{

        echo "Update failed";

    }

}
?>