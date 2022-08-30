<?php

if (isset($_POST["submitLogin"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    include "../classes/dbh-classes.php";
    include "../classes/login-classes.php";
    include "../classes/login-control-classes.php";

    $login = new LoginController($email, $password);

    $login->loginUser();
    
} else {
    header("location: ../index.php");
    exit();
}