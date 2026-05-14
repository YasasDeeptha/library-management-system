<?php

session_start();


$_SESSION = [];

session_destroy();



header(
    "Location: /library-management-system/features/auth/superadmin-login.php"
);

exit();

?>