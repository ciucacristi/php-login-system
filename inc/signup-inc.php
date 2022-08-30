<?php

if (isset($_POST['submitSignup'])) {
    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];

    include "../classes/dbh-classes.php";
    include "../classes/signup-classes.php";
    include "../classes/signup-control-classes.php";

    $signup = new SignupController($firstName, $lastName, $email, $password, $repeatPassword);

    $signup->signupUser();

    header("location: ../signup.php?error=none");
    
} else {
    header('location: ../signup.php');
}