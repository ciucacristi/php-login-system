<?php
if (isset($_POST["reset-request-submit"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = $_SERVER['SERVER_NAME'].dirname(dirname($_SERVER['PHP_SELF']))."/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;
    $userEmail = $_POST["resetEmail"];

    include "../classes/dbh-classes.php";
    include "../classes/reset-request-classes.php";

    $ResetRequestPassword = new ResetRequestPassword($userEmail, $selector, $token, $url, $expires);
    $ResetRequestPassword->ResetRequest();
  
} else {
    header("location: ../reset-password.php?error=notreseted");
}