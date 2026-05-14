<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

  
    // HARDCODED SUPER ADMIN
   

    $superAdminUsername = "admin";
    $superAdminPassword = "admin123";


    if(
        $username === $superAdminUsername &&
        $password === $superAdminPassword
    ){

        $_SESSION['super_admin'] = true;
        $_SESSION['super_admin_username'] = $username;

        echo "success";

    }else{

        echo "Invalid super admin credentials";

    }

}else{

    echo "Invalid Request";

}
?>