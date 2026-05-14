<?php


session_start();

require_once '../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    if (empty($username) || empty($password)) {

        echo "All fields are required";
        exit;
    }

    if (!preg_match("/^[a-zA-Z0-9_@.]+$/", $username)) {

        echo "Invalid username or email";
        exit;
    }

    if (strlen($password) < 8) {

        echo "Password must be at least 8 characters";
        exit;
    }



    $sql = "SELECT * FROM user
            WHERE username = ?
            OR email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $username, $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();



        if (password_verify($password, $user['password'])) {



            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];



            setcookie(
                "library_user",
                $user['username'],
                time() + (86400 * 7),
                "/"
            );

            echo "success";
        } else {

            echo "Incorrect password";
        }
    } else {

        echo "User not found";
    }
} else {

    echo "Invalid Request";
}
