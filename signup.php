<?php
    include_once 'header.php';
?>
<?php if (!isset($_SESSION['userid'])) { ?>

    <div class="container my-5 p-5">
        <h2 class="text-center">Sign Up</h2>

       <div class="col-lg-6 mx-auto my-5">
        <!-- Sign up Form -->
        <form action="inc/signup-inc.php" method="post">
            <div class="row mb-4">
                <div class="col">
                    <input type="text" name="firstName" class="form-control" placeholder="First name">
                </div>

                <div class="col">
                    <input type="text" name="lastName" class="form-control" placeholder="Last name">
                </div>
            </div>

            <div class="mb-4">
                <input type="email" name="email" class="form-control <?php if (isset($_GET["error"])) { if($_GET["error"] == "invalidemail" || $_GET["error"] == "emailtaken") { echo 'is-invalid'; } } ?>" placeholder="Email">
            </div>

            <div class="mb-4">
                <input type="password" name="password" class="form-control <?php if (isset($_GET["error"])) { if($_GET["error"] == "invalidpassword" || $_GET["error"] == "passwordsdontmatch") { echo 'is-invalid'; } } ?>" placeholder="Password">
            </div>

            <div class="mb-4">
                <input type="password" name="repeatPassword" class="form-control <?php if (isset($_GET["error"])) { if($_GET["error"] == "passwordsdontmatch") { echo 'is-invalid'; } } ?>" placeholder="Repeat Password">
            </div>

            <button type="submit" name="submitSignup" class="btn btn-primary mb-3">Submit</button>
        </form>

        <?php 
            // Displaying error messages
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "signupemptyinputs") {
                    echo "<p class='text-danger'>Fill in all fields!</p>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<p class='text-danger'>Invalid email!</p>";
                } else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p class='text-danger'>Passwords doesn't match!</p>";
                } else if ($_GET["error"] == "emailtaken") {
                    echo "<p class='text-danger'>Email it's already taken!</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='text-danger'>Something went wrong, try again later!</p>";
                } else if ($_GET["error"] == "invalidpassword") {
                    echo "<p class='text-danger'>Make sure your password contains at least 8 characters, a Capital letter, a number and a special charcter.</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='text-success'>Your account was succesfully created!</p>";
                }
            }
        ?>

       </div>
    </div>

<?php } else {
    header("location:". dirname("index.php"));
    exit();
} ?>
  
<?php
    include_once 'footer.php';
?>