<?php

session_start();

require_once '../../config/database.php';

if(isset($_GET['id'])){

    $user_id = $_GET['id'];

    // VALIDATE FORMAT
    if(!preg_match("/^U[0-9]{3}$/", $user_id)){

        die("Invalid User ID");

    }

    $sql = "DELETE FROM user WHERE user_id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $user_id);

    if($stmt->execute()){

        header("Location: manage.php");
        exit();

    }else{

        echo "Delete failed";

    }

}else{

    echo "Invalid Request";

}
?>