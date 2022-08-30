<?php

if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["newPassword"];
    $passwordRepeat = $_POST["repeatNewPassword"];

    include "../classes/dbh-classes.php";
    include "../classes/reset-password-classes.php";

    $resetPass = new ResetPassword($selector, $validator, $password, $passwordRepeat);
    $resetPass->newPassword();

} else {
    header("location: ../reset-password.php");
}