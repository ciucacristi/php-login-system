<?php

include "../classes/dbh-classes.php";
include "../classes/login-classes.php";
include "../classes/login-control-classes.php";

$logout = new Login();
$logout->logout();

session_start();
session_unset();
session_destroy();

// Destroy the cookies
unset($_COOKIE['userId']);
unset($_COOKIE['passToken']);
setcookie('userId', '', time() - 3600, '/');
setcookie('passToken', '', time() - 3600, '/');

header("location: ../index.php");