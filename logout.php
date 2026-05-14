<?php

session_start();

session_unset();
session_destroy();

setcookie("library_user", "", time() - 3600, "/");

header("Location: index.php");

?>