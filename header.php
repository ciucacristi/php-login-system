<?php 
include "inc/autoloader.php";
session_start();

if (!isset($_SESSION['userid'])) {
    $validToken = new Login();
    $validToken->validToken();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>

  <!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light py-3">
    <div class="container">
        <a class="navbar-brand" href="#">Login</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                    </li>
                </ul>
            </div>


            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <?php
                if (isset($_SESSION['userid'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='profile.php'>Profile</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='inc/logout-inc.php'>Log Out</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";

                }
            ?>
        </ul>

    </div>
</nav>
